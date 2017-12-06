<?php
/**
* @author 	Peter Taiwo
* @package 	Glider\Processor\Mysqli\MysqliProcessor
*/

namespace Glider\Processor\Mysqli;

use StdClass;
use Exception;
use RuntimeException;
use mysqli_sql_exception;
use Glider\Query\Parameters;
use Glider\Result\Collection;
use Glider\Result\ResultMapper;
use Glider\Query\Builder\QueryBuilder;
use Glider\Platform\Contract\PlatformProvider;
use Glider\Result\Contract\ResultMapperContract;
use Glider\Processor\AbstractProcessorProvider;
use Glider\Processor\Exceptions\QueryException;
use Glider\Processor\Contract\ProcessorProvider;
use Glider\Results\Contract\ResultObjectProvider;

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
	* {@inheritDoc}
	*/
	public function __construct(PlatformProvider $platformProvider)
	{
		$this->platformProvider = $platformProvider;
	}

	/**
	* {@inheritDoc}
	*/
	public function fetch(QueryBuilder $queryBuilder, Parameters $parameterBag) : Collection
	{
		$resolvedQueryObject = $this->resolveQueryObject($queryBuilder, $parameterBag);
		$statement = $resolvedQueryObject->statement;
		$connection = $resolvedQueryObject->connection;
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
		return $queryObject->statement;
	}

	/**
	* {@inheritDoc}
	*/
	public function update(QueryBuilder $queryBuilder, Parameters $parameterBag)
	{
		$queryObject = $this->resolveQueryObject($queryBuilder, $parameterBag);
		return $queryObject->statement;
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
	public function query(String $queryString)
	{
		
	}

	/**
	* Resolves query object returning: query, parameters and connection.
	*
	* @param 	$queryBuilder Glider\Query\Builder\QueryBuilder
	* @param 	$parameterBag Glider\Query\Parameters
	* @access 	private
	* @return 	Object
	* @throws 	Glider\Processor\Exceptions\QueryException;
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
		$connection = $this->platformProvider->connector()->connect();
		$query = $queryBuilder->getQuery();
		$sqlGenerator = $queryBuilder->generator;
		$queryObject = $sqlGenerator->convertToSql($query, $parameterBag);
		$query = $queryObject->query;

		$std->queryObject = $queryObject;
		$std->connection = $connection;

		$connection = $std->connection;
		$query = $queryObject->query;

		if (!$this->platformProvider->isAutoCommitEnabled()) {
			// Only start transaction manually if auto commit is not enabled.
			$transaction = $this->platformProvider->transaction();
		}

		// Turn error reporting on for mysqli
		mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

		try{

			$hasMappableFields = $sqlGenerator->hasMappableFields($query);

			// Attempt to prepare query, bind parameters dynamically and execute query.
			$statement = $connection->stmt_init();
			$statement->prepare($query);
			if (!empty($hasMappableFields) || in_array($queryBuilder->getQueryType(), [1, 2, 3])) {
				call_user_func_array([$statement, 'bind_param'], $boundParameters);
			}

			$statement->execute();
		}catch(mysqli_sql_exception $sqlExp) {
			throw new QueryException($sqlExp->getMessage(), $queryObject);
		}

		$std->statement = $statement;
		$std->transaction = $transaction;
		return $std;
	}

}