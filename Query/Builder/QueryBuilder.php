<?php
namespace Glider\Query\Builder;

use Glider\ClassLoader;
use Glider\Query\Parameters;
use Glider\Query\Builder\Type;
use Glider\Query\Builder\QueryBinder;
use Glider\Query\Builder\SqlGenerator;
use Glider\Connection\ConnectionManager;
use Glider\Platform\Contract\PlatformProvider;
use Glider\Statements\Contract\StatementProvider;
use Glider\Connectors\Contract\ConnectorProvider;
use Glider\Events\Subscribers\BuildEventsSubscriber;
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
	* @access 	public
	*/
	public 		$generator;

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
	* @var 		$strictType
	* @access 	private
	*/
	private 	$strictType;

	/**
	* @var 		$parameters
	* @access 	private
	*/
	private 	$parameters = [];

	/**
	* @var 		$provider
	* @access 	private
	*/
	private 	$provider;

	/**
	* @var 		$queryResult
	* @access 	private
	*/
	private 	$queryResult = null;

	/**
	* @var 		$statement
	* @access 	private
	*/
	private 	$statement;

	/**
	* @var 		$parameterBag
	* @access 	private
	*/
	private 	$parameterBag;

	/**
	* {@inheritDoc}
	*/
	public function __construct(ConnectionManager $connectionManager, PlatformProvider $platform)
	{
		$classLoader = new ClassLoader();
		$this->provider = $connectionManager->getConnection();
		$this->connector = $this->provider->connector();
		$this->statement = $this->provider->statement();
		$this->generator = $classLoader->getInstanceOfClass('Glider\Query\Builder\SqlGenerator');
		$this->binder = new QueryBinder();
		$this->parameterBag = new Parameters();
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
	public function setParam(String $key, $value)
	{
		$this->parameterBag->setParameter($key, $value);
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
	* {@inheritDoc}
	*/
	public function getResult()
	{
		$this->queryResult = [];
		if (is_null($this->queryResult)) {
			return;
		}

		return $this->statement->fetch($this, $this->parameterBag);
	}

	/**
	* {@inheritDoc}
	*/
	public function getQueryParameters() : Array
	{
		return $this->parameterBag->getAll();
	}

	/**
	* {@inheritDoc}
	*/
	public function getQuery() : String
	{
		return $this->sqlQuery;
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