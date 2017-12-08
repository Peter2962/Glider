<?php
namespace Glider\Schema;

use Closure;
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
	public function switchDatabase(String $databaseName)
	{

	}

	/**
	* {@inheritDoc}
	*/
	public function hasTable(String $table) : Bool
	{
		$hasTable = $this->queryBuilder->query(Expressions::showTable($table));
		if (!$hasTable instanceof QueryBuilder && $hasTable && $hasTable->numRows() > 0) {
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