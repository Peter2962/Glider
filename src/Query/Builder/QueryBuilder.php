<?php
namespace Kit\Glider\Query\Builder;

use RuntimeException;
use Kit\Glider\ClassLoader;
use Kit\Glider\Query\Parameters;
use InvalidArgumentException;
use Kit\Glider\Query\Builder\Type;
use Kit\Glider\Result\ResultMapper;
use Kit\Glider\Query\Builder\QueryBinder;
use Kit\Glider\Query\Builder\SqlGenerator;
use Kit\Glider\Connection\ConnectionManager;
use Kit\Glider\Platform\Contract\PlatformProvider;
use Kit\Glider\Result\Contract\ResultMapperContract;
use Kit\Glider\Processor\Contract\ProcessorProvider;
use Kit\Glider\Connectors\Contract\ConnectorProvider;
use Kit\Glider\Events\Subscribers\BuildEventsSubscriber;
use Kit\Glider\Query\Builder\Contract\QueryBuilderProvider;

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
	* @var 		$processorProvider
	* @access 	private
	*/
	private 	$processorProvider;

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
	* @var 		$allowedOperators
	* @access 	protected
	*/
	protected 	$allowedOperators = [];

	/**
	* @var 		$queryType
	* @access 	protected
	*/
	protected 	$queryType = 0;

	/**
	* {@inheritDoc}
	*/
	public function __construct(ConnectionManager $connectionManager)
	{
		$classLoader = new ClassLoader();
		$this->provider = $connectionManager->getConnection();
		$this->connector = $this->provider->connector();
		$this->processorProvider = $this->provider->processor();
		$this->generator = $classLoader->getInstanceOfClass('Kit\Glider\Query\Builder\SqlGenerator');
		$this->binder = new QueryBinder();
		$this->parameterBag = new Parameters();
		$this->allowedOperators = ['AND', 'OR', '||', '&&']; // Will add more here.
	}

	/**
	* {@inheritDoc}
	*/
	public function queryWithBinding(String $query, Bool $useDefaultQueryMethod=true) : QueryBuilderProvider
	{
		QueryBuilder::$isCustomQuery = true;
		$this->sqlQuery = $this->binder->createBinding('sql', $query);
		return $this;
	}

	/**
	* {@inheritDoc}
	*/
	public function query(String $queryString, int $type=1)
	{
		if ($this->provider->isQueryCompatible()) {
			return $this->processorProvider->query($queryString, $type);
		}

		return false;
	}

	/**
	* {@inheritDoc}
	*/
	public function select(...$arguments) : QueryBuilderProvider
	{
		if (sizeof($arguments) < 1) {
			$arguments = ['*'];
		}

		$this->queryType = 1;
		$this->sqlQuery = $this->binder->createBinding('select', $arguments);
		return $this;
	}

	/**
	* {@inheritDoc}
	*/
	public function least(Array $arguments, String $alias) : QueryBuilderProvider
	{
		if (sizeof($arguments) > 0) {
			$this->sqlQuery .= $this->binder->alias('LEAST(' . implode(',', $arguments) . ')', $alias);
		}
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
		$this->sqlQuery .= $this->binder->alias('AVG(' . $column . ')', $alias);
		return $this;
	}

	/**
	* {@inheritDoc}
	*/
	public function count(String $column, String $alias) : QueryBuilderProvider
	{
		$this->sqlQuery .= $this->binder->alias('COUNT(' . $column . ')', $alias);
		return $this;
	}

	/**
	* {@inheritDoc}
	*/
	public function sum(String $column, String $alias) : QueryBuilderProvider
	{
		$this->sqlQuery .= $this->binder->alias('SUM(' . $column . ')', $alias);
		return $this;
	}

	/**
	* {@inheritDoc}
	*/
	public function max(String $column, String $alias) : QueryBuilderProvider
	{
		$this->sqlQuery .= $this->binder->alias('MAX(' . $column . ')', $alias);
		return $this;
	}

	/**
	* {@inheritDoc}
	*/
	public function min(String $column, String $alias) : QueryBuilderProvider
	{
		$this->sqlQuery .= $this->binder->alias('MIN(' . $column . ')', $alias);
		return $this;
	}

	/**
	* {@inheritDoc}
	*/
	public function groupConcat(String $expression, String $alias, String $separator) : QueryBuilderProvider
	{
		$this->sqlQuery .= $this->binder->alias('GROUP_CONCAT(' . $expression . ')', $alias);
		return $this;
	}

	/**
	* {@inheritDoc}
	*/
	public function where(String $column, $value='') : QueryBuilderProvider
	{
		$this->sqlQuery .= $this->binder->createBinding('where', $column, $value, '=', 'AND', false);
		if (!empty($value)) {
			$this->setParam($column, $value);
		}

		return $this;
	}

	/**
	* {@inheritDoc}
	*/
	public function orWhere(String $column, $value='') : QueryBuilderProvider
	{
		$this->sqlQuery .= $this->binder->createBinding('where', $column, $value, '=', 'OR', false);
		if (!empty($value)) {
			$this->setParam($column, $value);
		}

		return $this;
	}

	/**
	* {@inheritDoc}
	*/
	public function andWhere(String $column, $value='') : QueryBuilderProvider
	{
		$this->sqlQuery .= $this->binder->createBinding('where', $column, $value, '=', 'AND', false);
		if (!empty($value)) {
			$this->setParam($column, $value);
		}

		return $this;
	}

	/**
	* {@inheritDoc}
	*/
	public function whereNot(String $column, $value='') : QueryBuilderProvider
	{
		$this->sqlQuery .= $this->binder->createBinding('where', $column, $value, '!=', 'AND', false);
		if (!empty($value)) {
			$this->setParam($column, $value);
		}

		return $this;
	}

	/**
	* {@inheritDoc}
	*/
	public function orWhereNot(String $column, $value='') : QueryBuilderProvider
	{
		$this->sqlQuery .= $this->binder->createBinding('where', $column, $value, '!=', 'OR', false);
		if (!empty($value)) {
			$this->setParam($column, $value);
		}

		return $this;
	}

	/**
	* {@inheritDoc}
	*/
	public function andWhereNot(String $column, $value='') : QueryBuilderProvider
	{
		$this->sqlQuery .= $this->binder->createBinding('where', $column, $value, '!=', 'AND', false);
		if (!empty($value)) {
			$this->setParam($column, $value);
		}

		return $this;
	}

	/**
	* {@inheritDoc}
	*/
	public function whereIn(String $column, Array $values) : QueryBuilderProvider
	{
		if (!empty($this->binder->getBinding('select')) && sizeof($values) > 0) {
			$values = implode(',', $values);
			$this->sqlQuery .= ' WHERE ' . $column . ' IN (' . $values . ')';
		}

		return $this;
	}

	/**
	* {@inheritDoc}
	*/
	public function whereBetween(String $column, $leftValue=null, $rightValue=null) : QueryBuilderProvider
	{
		$this->sqlQuery .= $this->binder->createBinding('between', $column, $leftValue, $rightValue, 'AND', true);
		return $this;
	}

	/**
	* {@inheritDoc}
	*/
	public function whereNotBetween(String $column, $leftValue=null, $rightValue=null) : QueryBuilderProvider
	{
		$this->sqlQuery .= $this->binder->createBinding('between', $column, $leftValue, $rightValue, 'AND', false);
		return $this;
	}

	/**
	* {@inheritDoc}
	*/
	public function whereNotIn(String $column, Array $values) : QueryBuilderProvider
	{
		if (!empty($this->binder->getBinding('select')) && sizeof($values) > 0) {
			$values = implode(',', $values);
			$this->sqlQuery .= ' WHERE ' . $column . ' NOT IN (' . $values . ')';
		}
		
		return $this;
	}

	/**
	* {@inheritDoc}
	*/
	public function whereLike(String $column, String $pattern, String $operator='AND') : QueryBuilderProvider
	{
		$this->sqlQuery .= $this->binder->createBinding('like', $column, $pattern, $operator, true);
		return $this;
	}

	/**
	* {@inheritDoc}
	*/
	public function whereNotLike(String $column, String $pattern, String $operator='AND') : QueryBuilderProvider
	{
		$this->sqlQuery .= $this->binder->createBinding('like', $column, $pattern, $operator, false);
		return $this;
	}

	/**
	* {@inheritDoc}
	*/	
	public function limit(Int $limit, Int $offset=0) : QueryBuilderProvider
	{
		$this->sqlQuery .= ' LIMIT ' . $limit;
		if ($offset > 0) {
			$this->sqlQuery .= ' OFFSET ' . $offset;
		}

		return $this;
	}

	/**
	* {@inheritDoc}
	*/
	public function orderBy(Array $columns) : QueryBuilderProvider
	{
		$columns = implode(',', $columns);
		$this->sqlQuery .= $this->setOrderByFunction(' ORDER BY ' . $columns, '');
		return $this;
	}

	/**
	* {@inheritDoc}
	*/
	public function orderByField(Array $columns) : QueryBuilderProvider
	{
		$columns = implode(',', $columns);
		$this->sqlQuery .= $this->setOrderByFunction($columns, 'FIELD');
		return $this;
	}

	/**
	* {@inheritDoc}
	*/
	public function setParam(String $key, $value) : QueryBuilderProvider
	{
		$this->parameterBag->setParameter($key, $value);
		return $this;
	}

	/**
	* {@inheritDoc}
	*/
	public function get(Bool $nullifyResultAccess=false)
	{
		$this->queryResult = [];
		if (is_null($this->queryResult)) {
			return;
		}

		return $this->processorProvider->fetch($this, $this->parameterBag);
	}

	/**
	* {@inheritDoc}
	*/
	public function setResultMapper($resultMapper) : QueryBuilderProvider
	{
		$this->resultMapper = $resultMapper;
		return $this;
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
	* {@inheritDoc}
	*/
	public function setOperator(String $operator) : QueryBuilderProvider
	{
		if (in_array($operator, $this->allowedOperators) && $this->sqlQuery !== '') {
			$this->sqlQuery .= $operator;
		}

		return $this;
	}

	/**
	* {@inheritDoc}
	*/
	public function insert(String $table, Array $fields=[])
	{
		foreach(array_keys($fields) as $field) {
			$this->setParam($field, $fields[$field]);
		}

		$this->queryType = 2;
		$this->sqlQuery = $this->binder->createBinding('insert', $table, $fields);
		return $this->processorProvider->insert($this, $this->parameterBag);
	}

	/**
	* {@inheritDoc}
	*/
	public function update(String $table, Array $fields=[])
	{
		foreach(array_keys($fields) as $field) {
			$this->setParam($field, $fields[$field]);
		}

		$this->queryType = 3;
		$this->sqlQuery = $this->binder->createBinding('update', $table, $fields);
		return $this->processorProvider->update($this, $this->parameterBag);
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

	/**
	* Return an integer value of query type.
	*
	* @access 	public
	* @return 	Integer
	*/
	public function getQueryType() : int
	{
		return $this->queryType;
	}

	/**
	* This method is used to set a field on ORDER BY clause.
	*
	* @param 	$query <String>
	* @access 	protected
	* @return 	String
	*/
	protected function setOrderByFunction(String $query, String $functionName) : String
	{
		if ($functionName !== null && $functionName !== '') {
			$query = ' ORDER BY ' . $functionName . '(' . $query . ')';
		}

		return $query;
	}

}