<?php
namespace Glider\Schema\Contract;

use Closure;
use Glider\Connection\ConnectionManager;

interface SchemaManagerContract
{

	/**
	* Constructor accepts an optional parameter which is the connection id.
	*
	* @param 	$connectionId <String>
	* @access 	public
	* @return 	void
	*/
	public function __construct(String $connectionId=null);

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
	* Alter a table.
	*
	* @param 	$tableName <String>
	* @param 	$column <Closure>
	* @access 	public
	* @return 	void
	*/
	public function modifyTable(String $tableName, Closure $column);

}