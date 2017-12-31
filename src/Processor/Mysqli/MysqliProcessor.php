<?php
/**
* @author 	Peter Taiwo
* @package 	Kit\Glider\Processor\Mysqli\MysqliProcessor
*/

namespace Kit\Glider\Processor\Mysqli;

use StdClass;
use Exception;
use RuntimeException;
use mysqli_sql_exception;
use Kit\Glider\Query\Parameters;
use Kit\Glider\Result\Collection;
use Kit\Glider\Result\ResultMapper;
use Kit\Glider\Query\Builder\QueryBuilder;
use Kit\Glider\Result\Platforms\MysqliResult;
use Kit\Glider\Platform\Contract\PlatformProvider;
use Kit\Glider\Processor\AbstractProcessorProvider;
use Kit\Glider\Processor\Exceptions\QueryException;
use Kit\Glider\Processor\Contract\ProcessorProvider;
use Kit\Glider\Statements\Platforms\MysqliStatement;
use Kit\Glider\Result\Contract\ResultMapperContract;
use Kit\Glider\Results\Contract\ResultObjectProvider;

class MysqliProcessor extends AbstractProcessorProvider implements ProcessorProvider
{

	/**
	* @var 		$platformProvider
	* @access 	private
	*/
	private 	$platformProvider;

	/**
	* @var 		$sqlGenerator
	* @access 	private
	*/
	private 	$sqlGenerator;

	/**
	* We are setting this to protected because we'll be setting the result
	* internally.
	*
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
	* {@inheritDoc}
	*/
	public function __construct(PlatformProvider $platformProvider)
	{
		$this->platformProvider = $platformProvider;
		$this->connection = $platformProvider->connector()->connect();
	}

	/**
	* {@inheritDoc}
	*/
	public function fetch(QueryBuilder $queryBuilder, Parameters $parameterBag) : Collection
	{
		$resolvedQueryObject = $this->resolveQueryObject($queryBuilder, $parameterBag);
		$statement = $resolvedQueryObject->statement;
		$resultMetaData = $statement->result_metadata();

		$result = [];
		$params = [];
		$mappedFields = [];

		while ($field = $resultMetaData->fetch_field()) {
			$var = $field->name; 
			$mappedFields[] = $var;
			$$var = null; 
			$params[] = &$$var;
		}

		try {

			$statement->store_result();
			call_user_func_array([$statement, 'bind_result'], $params);

			while($statement->fetch()) {

				$resultStdClass = new StdClass();

				if ($queryBuilder->resultMappingEnabled()) {

					$mapper = $queryBuilder->getResultMapper();
					
					$mapper = new $mapper();
					
					if ($mapper instanceof ResultMapper) {
					
						$resultStdClass = $mapper;
					
						if (!$resultStdClass->register()) {
					
							continue;
					
						}
					
					}
				
				}

				foreach($mappedFields as $field) {
					// If no `ResultMapper` class is registered or provided, we'll use
					// `StdClass` to store and retrieve our columns instead.
					if (!$queryBuilder->resultMappingEnabled()) {
						$resultStdClass->$field = $$field;
						continue;
					}

					if (!property_exists($resultStdClass, $field)) {
						throw new RuntimeException(sprintf("Result Mapping Failed. Property %s does not exist in Mapper class.", $field));
					}

					// Here, each field will be mapped to a class property if the class
					// exists.
					$resultStdClass->mapFieldToClassProperty($field, $$field);
				}

				$result[] = $resultStdClass;
			}

		}catch(mysqli_sql_exception $sqlExp) {

			throw new QueryException($sqlExp->getMessage(), $resolvedQueryObject->queryObject);
		
		}

		$this->result = $result;
		
		return new Collection($this, $statement);
	}

	/**
	* {@inheritDoc}
	*/
	public function insert(QueryBuilder $queryBuilder, Parameters $parameterBag)
	{
		$queryObject = $this->resolveQueryObject($queryBuilder, $parameterBag);
		return new MysqliStatement($queryObject->statement);
	}

	/**
	* {@inheritDoc}
	*/
	public function update(QueryBuilder $queryBuilder, Parameters $parameterBag)
	{
		$queryObject = $this->resolveQueryObject($queryBuilder, $parameterBag);
		return new MysqliStatement($queryObject->statement);
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
	public function query(String $queryString, int $returnType=1)
	{
		$queryObject = $this->connection->query($queryString);

		if (!$queryObject) {
		
			return false;
		
		}

		if ($returnType == 1) {

			return new MysqliResult($queryObject);
		
		}

		return new MysqliStatement($queryObject);
	}

	/**
	* Resolves query object returning: query, parameters and connection.
	*
	* @param 	$queryBuilder Kit\Glider\Query\Builder\QueryBuilder
	* @param 	$parameterBag Kit\Glider\Query\Parameters
	* @access 	private
	* @return 	Object
	* @throws 	Kit\Glider\Processor\Exceptions\QueryException;
	*/
	private function resolveQueryObject(QueryBuilder $queryBuilder, Parameters $parameterBag) : StdClass
	{
		$std = new StdClass();
		$parameterTypes = '';
		$boundParameters = [];

		if ($parameterBag->size() > 0) {

			foreach(array_values($parameterBag->getAll()) as $param) {
				
				$isset = false;

				if (is_array($param)) {

					foreach($param as $p) {
					
						$parameterTypes .= $parameterBag->getType($p);

						$isset = true;
					
					}
				
				}

				if ($isset == true) {
				
					continue;
				
				}

				$parameterTypes .= $parameterBag->getType($param);
			}

			$boundParameters[] = $parameterTypes;

			$count = 0;
			$values = array_values($parameterBag->getAll());
			$paramValues = [];

			while ($count <= count($values) - 1) {
				$value = $values[$count];
				$isBound = false;
				if (is_array($value)) {
					foreach($value as $val) {
						$boundParameters[] =& $val;
					}
				}

				if (!is_array($value)) {
					$boundParameters[] =& $values[$count];
				}
				
				$count++;
			}
		}


		$transaction = null;

		$query = $queryBuilder->getQuery();
		$sqlGenerator = $queryBuilder->generator;
		$queryObject = $sqlGenerator->convertToSql($query, $parameterBag);
		$query = $queryObject->query;

		$std->queryObject = $queryObject;
		$query = $queryObject->query;

		// Turn error reporting on for mysqli
		mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

		try{

			$hasMappableFields = $sqlGenerator->hasMappableFields($query);

			if (!$this->platformProvider->isAutoCommitEnabled()) {

				// Only start transaction manually if auto commit is not enabled.
				$transaction = $this->platformProvider->transaction();
				$transaction->begin($this->connection);

			}

			$statement = $this->connection->stmt_init();
			
			$statement->prepare($query);

			if (!empty($hasMappableFields) || in_array($queryBuilder->getQueryType(), [1, 2, 3]) && !empty($boundParameters)) {

				call_user_func_array([$statement, 'bind_param'], $boundParameters);

			}

			$statement->execute();

			if (!$this->platformProvider->isAutoCommitEnabled()) {

				$transaction->commit($this->connection); // Commit transaction
				
			}


		}catch(mysqli_sql_exception $sqlExp) {

			if (!$this->platformProvider->isAutoCommitEnabled()) {

				$transaction->rollback($this->connection);

			}

			throw new QueryException($sqlExp->getMessage(), $queryObject);

		}

		$std->statement = $statement;
		$std->transaction = $transaction;

		return $std;
	}

}