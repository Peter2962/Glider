<?php
namespace Glider\Schema;

use Closure;
use Glider\Schema\Table;
use Glider\Schema\Column;
use Glider\Schema\Expressions;
use Glider\Query\Builder\QueryBuilder;
use Glider\Connection\ConnectionManager;
use Glider\Schema\Contract\SchemaManagerContract;

class SchemaManager implements SchemaManagerContract
{

	/**
	* @var 		$platformProvider
	* @access 	protected
	*/
	protected 	$platformProvider;

	/**
	* @var 		$connectionId
	* @access 	protected
	*/
	protected static $connectionId;

	/**
	* @var 		$processor
	* @access  	protected
	*/
	protected 	$processor;

	/**
	* @var 		$queryBuilder
	* @access 	protected
	*/
	protected 	$queryBuilder;

	/**
	* {@inheritDoc}
	*/
	public function __construct(String $connectionId=null, QueryBuilder $queryBuilder)
	{
		$this->queryBuilder = $queryBuilder;
	}

	/**
	* {@inheritDoc}
	*/
	public static function __callStatic($method, $parameters)
	{
		//
	}

	/**
	* {@inheritDoc}
	*/
	public function createDatabase(String $databaseName)
	{
		return $this->runQueryWithExpression(Expressions::createDatabase($databaseName), 0);
	}

	/**
	* {@inheritDoc}
	*/
	public function createDatabaseIfNotExist(String $databaseName)
	{
		return $this->runQueryWithExpression(Expressions::createDatabaseIfNotExist($databaseName));
	}

	/**
	* {@inheritDoc}
	*/
	public function switchDatabase(String $databaseName)
	{
		return $this->runQueryWithExpression(Expressions::switchDatabase($databaseName));
	}

	/**
	* {@inheritDoc}
	*/
	public function dropDatabase(String $databaseName)
	{
		return $this->runQueryWithExpression(Expressions::dropDatabase($databaseName));
	}

	/**
	* {@inheritDoc}
	*/
	public function hasTable(String $table) : Bool
	{
		$hasTable = $this->queryBuilder->query(Expressions::showTable($table));
		if ($hasTable && $hasTable->numRows() > 0) {
			return true;
		}

		return false;
	}

	/**
	* {@inheritDoc}
	*/
	public function getAllTables()
	{
		return $this->queryBuilder->queryWithBinding(Expressions::allTables())->get()->all();
	}

	/**
	* {@inheritDoc}
	*/
	public function hasColumn(String $table, String $column) : Bool
	{
		if ($result = $this->runQueryWithExpression(Expressions::hasColumn($table, $column))) {
			if ($result->numRows() > 0) {
				return true;
			}

			return false;
		}

		return false;
	}

	/**
	* {@inheritDoc}
	*/
	public function getColumns(String $table)
	{
		return $this->queryBuilder->queryWithBinding(Expressions::getColumns($table))->get()->all();
	}

	/**
	* {@inheritDoc}
	*/
	public function getColumnNames(String $table)
	{
		return $this->getColumnKeys($table, 'Field');
	}

	/**
	* {@inheritDoc}
	*/
	public function getColumnType(String $table, String $columnName)
	{
		if ($column = $this->getColumn($table, $columnName)) {
			return $column->Type;
		}
	}

	/**
	* {@inheritDoc}
	*/
	public function getColumn(String $table, String $columnName)
	{
		if (!$columns = $this->getColumns($table)) {
			return false;
		}

		foreach($columns as $column) {
			if ($column->Field == $columnName) {
				return $column;
			}
		}
	}

	/**
	* @param 	$expression <String>
	* @param 	$type <Integer>
	* @access 	protected
	* @return 	Mixed
	*/
	protected function runQueryWithExpression(String $expresison, int $type=1)
	{
		return $this->queryBuilder->query($expresison, $type);
	}

	/**
	* @param 	$table <String>
	* @param 	$key <String>
	* @access 	protected
	* @return 	Mixed
	*/
	protected function getColumnKeys(String $table, String $key)
	{
		if (!$columns = $this->getColumns($table)) {
			return false;
		}

		$keys = array_map(function($column) use ($key) {
			if (isset($column->$key)) {
				return $column->$key;
			}
		}, $columns);

		return $keys;
	}

	/**
	* {@inheritDoc}
	*/
	public function table(String $table, Closure $column)
	{

	}
}