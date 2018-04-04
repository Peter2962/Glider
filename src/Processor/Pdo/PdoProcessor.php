<?php
/**
* MIT License
* Permission is hereby granted, free of charge, to any person obtaining a copy
* of this software and associated documentation files (the "Software"), to deal
* in the Software without restriction, including without limitation the rights
* to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
* copies of the Software, and to permit persons to whom the Software is
* furnished to do so, subject to the following conditions:

* The above copyright notice and this permission notice shall be included in all
* copies or substantial portions of the Software.

* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
* IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
* FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
* AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
* LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
* OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
* SOFTWARE.
*/

/**
* @author 	Peter Taiwo
* @package 	Kit\Glider\Processor\Pdo\PdoProcessor
*/

#####################
# Pdo processor class
#####################

namespace Kit\Glider\Processor\Pdo;

use PDO;
use StdClass;
use PDOException;
use Kit\Glider\Query\Parameters;
use Kit\Glider\Result\Collection;
use Kit\Glider\Result\ResultMapper;
use Kit\Glider\Query\Builder\QueryBuilder;
use Kit\Glider\Statements\Platforms\PdoStatement;
use Kit\Glider\Platform\Contract\PlatformProvider;
use Kit\Glider\Processor\AbstractProcessorProvider;
use Kit\Glider\Processor\Exceptions\QueryException;
use Kit\Glider\Processor\Contract\ProcessorProvider;
use Kit\Glider\Result\Contract\ResultMapperContract;
use Kit\Glider\Statements\Contract\StatementContract;
use Kit\Glider\Results\Contract\ResultObjectProvider;

class PdoProcessor extends AbstractProcessorProvider implements ProcessorProvider
{

	/**
	* @var 		$platform
	* @access 	private
	*/
	private 	$platform;

	/**
	* @var 		$sqlGenerator
	* @access 	private
	*/
	private 	$sqlGenerator;

	/**
	* @var 		$result
	* @access 	protected
	*/
	protected 	$result;

	/**
	* @var 		$connection
	* @access 	protected
	*/
	protected 	$connection;

	/**
	* @const 	DEFAULT_PARAM_TYPE
	*/
	const 		DEFAULT_PARAM_TYPE = PDO::PARAM_STR;

	/**
	* {@inheritDoc}
	*/
	public function __construct(PlatformProvider $platform)
	{
		$this->platform = $platform;
		$this->connection = $platform->connector()->connect();
	}

	/**
	* {@inheritDoc}
	*/
	public function fetch(QueryBuilder $queryBuilder, Parameters $parametersRepository) : Collection
	{
		$queryObject = $this->resolveQuery($queryBuilder, $parametersRepository);
		$statement = new PdoStatement($queryObject->statement);

		if ($queryBuilder->resultMappingEnabled()) {

			$mapper = $queryBuilder->getResultMapper();

			if (gettype($mapper) == 'string') {
				$mapper = new $mapper();
			}

			if ($mapper instanceof ResultMapper && $mapper->register()) {
				$result = $queryObject->statement->fetchAll(PDO::FETCH_CLASS, $mapper->getMapperName());
			}
		}else{
			$result = $queryObject->statement->fetchAll(PDO::FETCH_OBJ);
		}

		$this->result = $result;
		return new Collection($this);
	}

	/**
	* {@inheritDoc}
	*/
	public function insert(QueryBuilder $queryBuilder, Parameters $parameters) : StatementContract
	{
		$query = $this->resolveQuery($queryBuilder, $parameters);
		$query->statement->lastInsertId = $query->connection->lastInsertId();
		$query->statement->closeCursor();
		return new PdoStatement($query->statement);
	}

	/**
	* {@inheritDoc}
	*/
	public function update(QueryBuilder $queryBuilder, Parameters $parameters) : StatementContract
	{
		$query = $this->resolveQuery($queryBuilder, $parameters);
		$query->statement->closeCursor();
		return new PdoStatement($query->statement);
	}

	/**
	* {@inheritDoc}
	*/
	public function delete(QueryBuilder $queryBuilder, Parameters $parameterBag) : StatementContract
	{
		$query = $this->resolveQuery($queryBuilder, $parameters);
		$query->statement->closeCursor();
		return new PdoStatement($query->statement);		
	}

	/**
	* {@inheritDoc}
	*/
	public function getResult()
	{
		return $this->result;
	}

	/**
	* {@inheritDoc}
	*/
	public function query(String $queryString, int $queryType=1)
	{
		$queryObject = $this->connection->query($queryString);
		return new PdoStatement($queryObject);
	}

	/**
	* Resolves given query.
	*
	* @param 	$queryBuilder <Kit\Glider\Query\Builder\QueryBuilder>
	* @param 	$parametersRepository <Kit\Glider\Query\Parameters>
	* @access 	protected
	* @return 	Object
	*/
	protected function resolveQuery(QueryBuilder $queryBuilder, Parameters $parametersRepository) : StdClass
	{
		$queryObject = new StdClass;
		$connection = $this->connection;
		$statement = $connection->prepare($queryBuilder->getQuery());
		$transaction = null;

		try {

			$executeParameters = null;
			// bind query parameters.

			$parameters = $parametersRepository->getAll();
			if ($parametersRepository->size() > 0) {

				foreach(array_keys($parameters) as $i => $parameter) {
					$i += 1; // Increase index by 1 to avoid bindParam error.

					$paramValue = $parameters[$parameter];
					$paramType = self::DEFAULT_PARAM_TYPE;

					// The parameter data type is being checked here 
					switch ($parametersRepository->getType($paramValue)) {
						case 'i':
							$paramType = PDO::PARAM_INT;
							break;
						case 'd':
						case 's':
							$paramType = PDO::PARAM_STR;
							break;
						default:
							$paramType = PDO::PARAM_NULL;
							break;
					}
					if ($queryBuilder->getQueryType() !== 3) {
						if ($queryBuilder->getQueryType() == 2) {
							$statement->bindValue($i, $paramValue, $paramType);
						}else{
							$statement->bindParam($i, $paramValue, $paramType);
						}
					}
				}
			}

			if ($queryBuilder->getQueryType() == 3) {
				$executeParameters = $parameters;
			}
			
			if ($queryBuilder->getQueryType() == 1 && $executeParameters == null) {
				$executeParameters = $parameters;
			}

			$autocommitDisabled = !$this->platform->isAutoCommitEnabled() && in_array($queryBuilder->getQueryType(), [2, 3]);
				
			if ($autocommitDisabled) {
				$transaction = $this->platform->transaction();
				$transaction()->begin($connection);
			}

			$statement->execute($executeParameters);

			if ($autocommitDisabled) {
				$transaction->commit($connection);
			}

		} catch(PdoException $exception) {

			if ($autocommitDisabled) {
				$transaction->rollback($connection);
			}

			throw new QueryException(
				$exception->getMessage(),
				$queryBuilder->generator->convertToSql($queryBuilder->getQuery(), $parametersRepository)
			);

		}

		$queryObject->statement = $statement;
		$queryObject->connection = $connection;
		return $queryObject;
	}

}