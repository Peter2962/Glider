<?php
namespace Glider\Schema;

use Closure;
use Glider\Schema\Expressions;
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
	* {@inheritDoc}
	*/
	public function __construct(String $connectionId=null)
	{
		$connectionManager = new ConnectionManager();
		$this->platformProvider = $connectionManager->getConnection($connectionId);
		$this->processor = $this->platformProvider->processor();
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
	public function switchDatabase(String $databaseName)
	{

	}

	/**
	* {@inheritDoc}
	*/
	public function hasTable(String $table) : Bool
	{
		$hasTable = $this->processor->query(Expressions::hasTable($table));
	}

	/**
	* Returns the columns on a table.
	*
	* @param 	$table <String>
	* @access 	protected
	* @return 	Array
	*/
	protected function getTableColumns(String $table) : Array
	{

	}

	/**
	* {@inheritDoc}
	*/
	public function modifyTable(String $table, Closure $column)
	{

	}

}