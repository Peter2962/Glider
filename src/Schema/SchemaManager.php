<?php
namespace Kit\Glider\Schema;

use Closure;
use Kit\Glider\Schema\Table;
use Kit\Glider\Schema\Column;
use Kit\Glider\Schema\Expressions;
use Kit\Glider\Query\Builder\QueryBuilder;
use Kit\Glider\Connection\ConnectionManager;
use Kit\Glider\Schema\Contract\SchemaManagerContract;

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
		return SchemaManager::table($table)->exists();
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
		return SchemaManager::table($table)->hasColumn($column);
	}

	/**
	* {@inheritDoc}
	*/
	public function getColumns(String $table)
	{
		return SchemaManager::table($table)->getColumns();
	}

	/**
	* {@inheritDoc}
	*/
	public function getColumnNames(String $table)
	{
		return SchemaManager::table($table)->getColumnNames();
	}

	/**
	* {@inheritDoc}
	*/
	public function getColumnTypes(String $table)
	{
		return SchemaManager::table($table)->getColumnTypes();
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
	public function getColumn(String $table, String $columnName) : Column
	{
		return SchemaManager::table($table)->getColumn($columnName);
	}

	/**
	* {@inheritDoc}
	*/
	public function setTableEngine(String $engine)
	{
		return SchemaManager::table($table)->setEngine($engine);
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
	* {@inheritDoc}
	*/
	public static function table(String $table)
	{
		return Table::getInstance($table);
	}
}