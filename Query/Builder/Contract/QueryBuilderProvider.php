<?php
/**
* @package 	QueryBuilderProvider
* @version 	0.1.0
*
* Query builder provider contract that returns an architecture of Glider's
* query builder. This contract must be implemented any query builder
* that will be used.
*/

namespace Glider\Query\Builder\Contract;

use Glider\Connection\ConnectionManager;
use Glider\Platform\Contract\PlatformProvider;
use Glider\Result\Contract\ResultMapperContract;

interface QueryBuilderProvider
{

	/**
	* The constructor accepts two arguments: Glider\Connection\ConnectionManager
	* and Glider\Platform\Contract\PlatformProvider
	*
	* @param 	$connectorProvider Glider\Connection\ConnectionManager
	* @param 	$platformProvider Glider\Platform\Contract\PlatformProvider
	* @access 	public
	* @return 	void
	*/
	public function __construct(ConnectionManager $connectionManager, PlatformProvider $platformProvider);

	/**
	* This method runs a raw sql query. This is useful when there is need to write
	* a custom query.
	*
	* @param 	$query <String>
	* @param 	$useDefaultQueryMethod <Boolean>
	* @access 	public
	* @return 	Mixed.
	*/
	public function rawQuery(String $query, Bool $useDefaultQueryMethod) : QueryBuilderProvider;

	/**
	* This method sets a parameter for a given column value in a query. This method accepts
	* two parameters. The first parameter is the parameter provided in the query. Each parameter
	* must should start with a semi-colon and then the parameter name. E.g `:name`. The second argument
	* is the parameter value.
	*
	* @param 	$key <String>
	* @param 	$value <Mixed>
	* @access 	public
	* @return 	Mixed
	*/
	public function setParam(String $key, $value);

	/**
	* Returns a result set of a select query.
	*
	* @param 	$nullifyResultAccess <Boolean>
	* @access 	public
	* @return 	Mixed
	*/
	public function getResult(Bool $nullifyResultAccess=false);

	/**
	* Sets the ResultMapper class to use. This method accepts either an array r
	* instance of Glider\Result\Contract\ResultMapperContract as it's parameter.
	*
	* @param 	$resultMapper;
	* @access 	public
	* @return 	Object
	*/
	public function setResultMapper($resultMapper);

	/**
	* Returns an array of query parameters.
	*
	* @access 	public
	* @return 	Array
	*/
	public function getQueryParameters() : Array;

	/**
	* Returns the query string.
	*
	* @access 	public
	* @return 	String
	*/
	public function getQuery() : String;

	/**
	* Returns the registered ResultMapper.
	*
	* @access 	public
	* @return 	String
	*/
	public function getResultMapper() : String;

	/**
	* This method checks if a `ResultMapper` class is being used for the current
	* operation.
	*
	* @access 	public
	* @return 	Boolean
	*/
	public function resultMappingEnabled() : Bool;

	/**
	* Binds a select query to the query binder. This method accepts mixed arguments.
	* It's arguments accepts model instances that can be used to generate fields attached
	* to that particular model.
	*
	* @param 	$arguments <Mixed>
	* @access 	public
	* @return 	Glider\Query\Builder\Contract\QueryBuilderProvider 
	*/
	public function select(...$arguments) : QueryBuilderProvider;

	/**
	* Return the smallest (minimum-valued) argumennt.
	*
	* @param 	$arguments <Array>
	* @param 	$alias <String>
	* @access 	public
	* @return 	Glider\Query\Builder\Contract\QueryBuilderProvider
	*/
	public function least(Array $arguments, String $alias) : QueryBuilderProvider;

	/**
	* Set table where data will be fetched. Since parameter type has been set,
	* we do not need to check if @param $table is of valid type or not.
	*
	* @param 	$table <String>
	* @access 	public
	* @return 	Glider\Query\Builder\QueryBuilderProvider
	*/
	public function from(String $table) : QueryBuilderProvider;

	/**
	* This method sets average `aggregate` function in a select statement.
	* The first parameter is the name of the column to apply the aggregate function
	* and the second parameter is the alias of the column. Note that both of these parameters
	* are required.
	*
	* @param 	$column <String>
	* @param 	$alias <String>
	* @access 	public
	* @return 	Glider\Query\Builder\QueryBuilderProvider
	*/
	public function avg(String $column, String $alias) : QueryBuilderProvider;

	/**
	* Set `count` aggregate function in a select statement.
	* The first parameter is the name of the column to apply the aggregate function
	* and the second parameter is the alias of the column. Note that both of these parameters
	* are required.
	*
	* @param 	$column <String>
	* @param 	$alias <String>
	* @access 	public
	* @return 	Glider\Query\Builder\QueryBuilderProvider
	*/
	public function count(String $column, String $alias) : QueryBuilderProvider;

	/**
	* Return the sum of a set of values. The SUM function ignores NULL values.
	* If no matching row found, the SUM function returns a NULL value.
	* The first parameter is the name of the column to apply the aggregate function
	* and the second parameter is the alias of the column. Note that both of these parameters
	* are required.
	*
	* @param 	$column <String>
	* @param 	$alias <String>
	* @access 	public
	* @return 	Glider\Query\Builder\QueryBuilderProvider
	*/
	public function sum(String $column, String $alias) : QueryBuilderProvider;

	/**
	* Return the maximum value in a set of values.
	*
	* @param 	$column <String>
	* @param 	$alias <String>
	* @access 	public
	* @return 	Glider\Query\Builder\QueryBuilderProvider
	*/
	public function max(String $column, String $alias) : QueryBuilderProvider;

	/**
	* Return the minimum value in a set of values.
	*
	* @param 	$column <String>
	* @param 	$alias <String>
	* @access 	public
	* @return 	Glider\Query\Builder\QueryBuilderProvider
	*/
	public function min(String $column, String $alias) : QueryBuilderProvider;

	/**
	* Specify rows to select in a SELECT statement based on a condition or expression.
	* This method accepts two parameters. The `setParam` does not need to be called. It will
	* be handled automatically in the method.
	*
	* @see 		Glider\Query\Builder\QueryBuilder::where
	* @param 	$column <String>
	* @param 	$value <Mixed>
	* @access 	public
	* @return 	Glider\Query\Builder\QueryBuilderProvider
	*/
	public function where(String $column, $value='') : QueryBuilderProvider;

	/**
	* Add `OR` operator to `WHERE` clause in a `SELECT` statement.
	*
	* @param 	$column <String>
	* @param 	$value <Mixed>
	* @access 	public
	* @return 	Glider\Query\Builder\QueryBuilderProvider
	*/
	public function orWhere(String $column, $value='') : QueryBuilderProvider;

	/**
	* Add `AND` operator to `WHERE` clause in a `SELECT` statement.
	*
	* @param 	$column <String>
	* @param 	$value <Mixed>
	* @access 	public
	* @return 	Glider\Query\Builder\QueryBuilderProvider
	*/
	public function andWhere(String $column, $value='') : QueryBuilderProvider;

	/**
	* Add `AND` operator to `WHERE` clause in a `SELECT` statement.
	*
	* @param 	$column <String>
	* @param 	$value <Mixed>
	* @access 	public
	* @return 	Glider\Query\Builder\QueryBuilderProvider
	*/
	public function whereNot(String $column, $value='') : QueryBuilderProvider;

}