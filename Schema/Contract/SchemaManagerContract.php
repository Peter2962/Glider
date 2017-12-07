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
	* Switch database if operation requires working from another database.
	*
	* @param 	$databaseName <String>
	* @access 	public
	* @return 	void
	*/
	public function switchDatabase(String $databaseName);

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
	* Alter a table.
	*
	* @param 	$tableName <String>
	* @param 	$column <Closure>
	* @access 	public
	* @return 	void
	*/
	public function modifyTable(String $tableName, Closure $column);

}