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

#####################
# Pdo processor class
#####################

namespace Kit\Glider\Processor\Pdo;

use StdClass;
use PDOException;
use Kit\Glider\Query\Parameters;
use Kit\Glider\Result\Collection;
use Kit\Glider\Result\ResultMapper;
use Kit\Glider\Query\Builder\QueryBuilder;
use Kit\Glider\Platform\Contract\PlatformProvider;
use Kit\Glider\Processor\AbstractProcessorProvider;
use Kit\Glider\Processor\Exceptions\QueryException;
use Kit\Glider\Processor\Contract\ProcessorProvider;
use Kit\Glider\Result\Contract\ResultMapperContract;
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
	public function fetch(QueryBuilder $queryBuilder, Parameters $parameters) : Collection
	{

	}

	/**
	* {@inheritDoc}
	*/
	public function insert(QueryBuilder $queryBuilder, Parameters $parameters)
	{
		$query = $this->resolveQuery($queryBuilder, $parameters);
	}

	/**
	* {@inheritDoc}
	*/
	public function update(QueryBuilder $queryBuilder, Parameters $parameters)
	{

	}

	/**
	* {@inheritDoc}
	*/
	public function getResult()
	{

	}

	/**
	* {@inheritDoc}
	*/
	public function query(String $queryString, int $queryType=1)
	{

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

		print '<pre>';
		print_r($this->connection);

		// bind query parameters.

		if ($parametersRepository->size() > 0) {
			$parameters = $parametersRepository->getAll();
			foreach(array_keys($parameters) as $i => $parameter) {
				$i += 1; // Increase index by 1 to avoid bindParam error.
			}
		}

		try {

		} catch(PdoException $exception) {

		}

		return $queryObject;
	}

}