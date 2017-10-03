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

interface QueryBuilderProvider
{

	/**
	* The constructor accepts an argument: Glider\Connection\ConnectionManager
	*
	* @param 	$connectorProvider Glider\Connection\ConnectionManager
	* @access 	public
	* @return 	void
	*/
	public function __construct(ConnectionManager $connectionManager);

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
	public function setParam($key, $value);

	/**
	* Returns a result set of a select query.
	*
	* @access 	public
	* @return 	Mixed
	*/
	public function getResult();

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

}