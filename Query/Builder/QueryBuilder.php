<?php
namespace Glider\Query\Builder;

use Glider\ClassLoader;
use Glider\Query\Builder\QueryBinder;
use Glider\Query\Builder\SqlGenerator;
use Glider\Connection\ConnectionManager;
use Glider\Connectors\Contract\ConnectorProvider;
use Glider\Query\Builder\Contract\QueryBuilderProvider;

class QueryBuilder implements QueryBuilderProvider
{

	/**
	* @var 		$connector
	* @access 	private
	*/
	private 	$connector;

	/**
	* @var 		$generator
	* @access 	private
	*/
	private 	$generator;

	/**
	* @var 		$bindings
	* @access 	protected
	*/
	protected 	$bindings = [];

	/**
	* @var 		$binder
	* @access 	protected
	*/
	protected 	$binder;

	/**
	* @var 		$sqlQuery
	* @access 	protected
	*/
	protected 	$sqlQuery;

	/**
	* @var 		$isCustomQuery
	* @access 	private
	* @static
	*/
	private static $isCustomQuery = false;

	/**
	* {@inheritDoc}
	*/
	public function __construct(ConnectionManager $connectionManager)
	{
		$classLoader = new ClassLoader();
		$this->connector = $connectionManager->getConnection()->connector();
		$this->generator = $classLoader->getInstanceOfClass('Glider\Query\Builder\SqlGenerator');
		$this->binder = new QueryBinder();
	}

	/**
	* {@inheritDoc}
	*/
	public function rawQuery(String $query, Bool $useDefaultQueryMethod=true) : QueryBuilderProvider
	{
		QueryBuilder::$isCustomQuery = true;
		// Here we are creating a binding for raw sql queries.
		$this->sqlQuery = $this->binder->createBinding('sql', $query);
		return $this;
	}

	/**
	* {@inheritDoc}
	*/
	public function select(...$arguments) : QueryBuilderProvider
	{
		if (sizeof($arguments) < 1) {
			$arguments = ['*'];
		}
		$this->binder->createBinding('select', $arguments);
		return $this;
	}

	/**
	* This static method checks if the last query is a custom query.
	*
	* @access 	public
	* @static
	* @return 	Boolean
	*/
	public static function lastQueryCustom()
	{
		return QueryBuilder::$isCustomQuery;
	}

}