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
		$queryObject = $this->resolveQueryObject($queryBuilder, $parameterBag);
		$connection = $queryObject->connection;
		$query = $queryObject->queryObject->query;

		if (!$this->platformProvider->isAutoCommitEnabled()) {
			// Only start transaction manually if auto commit is not enabled.
			$transaction = $this->platformProvider->transaction();
		}

		// Turn error reporting on for mysqli
		mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

		try{
			$statement = $connection->prepare($query);
		}catch(mysqli_sql_exception $sqlExp) {
			throw new QueryException($sqlExp->getMessage(), $queryObject->queryObject);
		}

		print '<pre>';
		print_r($connection);
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
	*/
	private function resolveQueryObject(QueryBuilder $queryBuilder, Parameters $parameterBag) : StdClass
	{
		$std = new StdClass();

		$connection = $this->platformProvider->connector()->connect();
		$query = $queryBuilder->getQuery();
		$sqlGenerator = $queryBuilder->generator;
		$queryObject = $sqlGenerator->convertToSql($query, $parameterBag);
		$query = $queryObject->query;

		$std->queryObject = $queryObject;
		$std->connection = $connection;

		return $std;
	}

}