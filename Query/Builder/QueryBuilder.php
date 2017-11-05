<?php
namespace Glider\Query\Builder;

use RuntimeException;
use Glider\ClassLoader;
use Glider\Query\Parameters;
use InvalidArgumentException;
use Glider\Query\Builder\Type;
use Glider\Result\ResultMapper;
use Glider\Query\Builder\QueryBinder;
use Glider\Query\Builder\SqlGenerator;
use Glider\Connection\ConnectionManager;
use Glider\Platform\Contract\PlatformProvider;
use Glider\Result\Contract\ResultMapperContract;
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
	* @var 		$resultMapper
	* @access 	private
	*/
	private 	$resultMapper;

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
	public function select(...$arguments) : QueryBuilderProvider
	{
		if (sizeof($arguments) < 1) {
			$arguments = ['*'];
		}

		$this->sqlQuery = $this->binder->createBinding('select', $arguments);
		return $this;
	}

	/**
	* {@inheritDoc}
	*/
	public function from(String $table) : QueryBuilderProvider
	{
		$this->sqlQuery .= ' FROM ' . $table;
		return $this;
	}

	/**
	* {@inheritDoc}
	*/
	public function avg(String $column, String $alias) : QueryBuilderProvider
	{
		if (!$this->binder->getBinding('select')) {
			// Since this method cannot be used without the SELECT statement,
			// we will throw an exception if `SELECT` binding is null or false. 
			throw new RuntimeException(sprintf('Cannot call aggregate function %s on empty select.', 'AVG'));
		}
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
	public function getResult(Bool $nullifyResultAccess=false)
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
	public function setResultMapper($resultMapper)
	{
		$this->resultMapper = $resultMapper;
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
	* {@inheritDoc}
	*/
	public function getResultMapper() : String
	{
		return $this->resultMapper;
	}

	/**
	* {@inheritDoc}
	*/
	public function resultMappingEnabled() : Bool
	{
		if (gettype($this->resultMapper) !== 'string' || !class_exists($this->resultMapper)) {
			return false;
		}

		return (new $this->resultMapper instanceof ResultMapper) ? true : false;
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