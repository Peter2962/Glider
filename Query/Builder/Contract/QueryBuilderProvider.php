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