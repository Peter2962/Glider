<?php
namespace Glider\Statements\Mysqli;

use StdClass;
use Exception;
use mysqli_sql_exception;
use Glider\Query\Parameters;
use Glider\Query\Builder\QueryBuilder;
use Glider\Platform\Contract\PlatformProvider;
use Glider\Statements\AbstractStatementProvider;
use Glider\Statements\Exceptions\QueryException;
use Glider\Statements\Contract\StatementProvider;
use Glider\Results\Contract\ResultObjectProvider;

class MysqliStatement extends AbstractStatementProvider implements StatementProvider
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
	* {@inheritDoc}
	*/
	public function __construct(PlatformProvider $platformProvider)
	{
		$this->platformProvider = $platformProvider;
	}

	/**
	* {@inheritDoc}
	*/
	public function fetch(QueryBuilder $queryBuilder, Parameters $parameterBag) : Array
	{
		$resolvedQueryObject = $this->resolveQueryObject($queryBuilder, $parameterBag);
		$statement = $resolvedQueryObject->statement;
		$connection = $resolvedQueryObject->connection;
		$resultMetaData = $statement->result_metadata();
		$result = [];
		$params = [];

		while ($field = $resultMetaData->fetch_field())
		{
			$var = $field->name; 
			$$var = null; 
			$params[] = &$$var;
		}

		try {
			call_user_func_array([$statement, 'bind_result'], $params);
			$resultMapper = $queryBuilder->getResultMapper();
			while($statement->fetch()) {

			}

		}catch(mysqli_sql_exception $sqlExp) {
			throw new QueryException($sqlExp->getMessage(), $resolvedQueryObject->queryObject);
		}

		return [];
	}

	/**
	* {@inheritDoc}
	*/
	public function insert()
	{

	}

	/**
	* Resolves query object returning: query, parameters and connection.
	*
	* @param 	$queryBuilder Glider\Query\Builder\QueryBuilder
	* @param 	$parameterBag Glider\Query\Parameters
	* @access 	private
	* @return 	Object
	* @throws 	Glider\Statements\Exceptions\QueryException;
	*/
	private function resolveQueryObject(QueryBuilder $queryBuilder, Parameters $parameterBag) : StdClass
	{
		$std = new StdClass();
		$parameterTypes = '';
		$boundParameters = [];

		if ($parameterBag->size() > 0) {

			foreach(array_values($parameterBag->getAll()) as $param) {
				$parameterTypes .= $parameterBag->getType($param);
			}

			$boundParameters[] = $parameterTypes;
			foreach(array_values($parameterBag->getAll()) as $param) {
				$boundParameters[] =& $param;
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
			if (!empty($hasMappableFields)) {
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