<?php
namespace Glider\Schema\Contract;

use Closure;
use Glider\Query\Builder\QueryBuilder;
use Glider\Connection\ConnectionManager;

interface SchemaManagerContract
{

	/**
	* Constructor accepts an optional parameter which is the connection id.
	*
	* @param 	$connectionId <String>
	* @param 	$queryBuilder <Glider\Query\Builder\QueryBuilder>
	* @access 	public
	* @return 	void
	*/
	public function __construct(String $connectionId=null, QueryBuilder $queryBuilder);

	/**
	* Call SchemaManager methods statically.
	*
	* @param 	$method <String>
	* @param 	$parameters <Array>
	* @access 	public
	* @return 	Mixed
	*/
	public static function __callStatic($method, $parameters);

	/**
	* Create database.
	*
	* @param 	$databaseName <String>
	* @access 	public
	* @return 	Mixed
	*/
	public function createDatabase(String $databaseName);

	/**
	* Creates database if it does not exist.
	*
	* @param 	$databaseName <String>
	* @access 	public
	* @return 	Mixed
	*/
	public function createDatabaseIfNotExist(String $databaseName);

	/**
	* Switch database using the USE statement.
	*
	* @param 	$databaseName <String>
	* @access 	public
	* @return 	Mixed
	*/
	public function switchDatabase(String $databaseName);

	/**
	* Drops a database.
	*
	* @param 	$databaseName <String>
	* @access 	public
	* @return 	Mixed
	*/
	public function dropDatabase(String $databaseName);

	/**
	* Check if database has a table.
	*
	* @param 	$table <String>
	* @access 	public
	* @return 	Boolean
	*/
	public function hasTable(String $table) : Bool;

	/**
	* Returns array of tables in the database.
	*
	* @access 	public
	* @return 	Array
	*/
	public function getAllTables();

	/**
	* Checks if a table has a column.
	*
	* @param 	$table <String>
	* @param 	$column <String>
	* @access 	public
	* @return 	Boolean
	*/
	public function hasColumn(String $table, String $column) : Bool;

	/**
	* Returns an array of a table's columns.
	*
	* @param 	$table <String>
	* @access 	public
	* @return 	Mixed
	*/
	public function getColumns(String $table);

	/**
	* Return array of columns names in a table.
	*
	* @param 	$table <String>
	* @access 	public
	* @return 	Mixed
	*/
	public function getColumnNames(String $table);

	/**
	* Returns a column in a table.
	*
	* @param 	$table <String>
	* @param 	$column <String>
	* @access 	public
	* @return 	Mixed
	*/
	public function getColumn(String $table, String $column);

	/**
	* Returns a column type in a table.
	*
	* @param 	$table <String>
	* @param 	$column <String>
	* @access 	public
	* @return 	Mixed
	*/
	public function getColumnType(String $table, String $column);

	/**
	* Return an instance of table.
	*
	* @param 	$tableName <String>
	* @param 	$column <Closure>
	* @access 	public
	* @return 	void
	*/
	// public function table(String $tableName, Closure $column);

}