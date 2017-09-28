<?php
/**
* @package 	Factory
* @version 	0.1.0
*
* This factory handles all database operations provided by
* Glider. The connection manager @see Glider\Connection\ConnectionManager can also
* be used to handle some operations.
*/

namespace Glider;

use Glider\Query\Builder\QueryBinder;
use Glider\Query\Builder\QueryBuilder;
use Glider\Connection\ConnectionManager;

class Factory
{

	/**
	* @var 		$provider
	* @access 	protected
	*/
	protected 	$provider;

	/**
	* @var 		$queryBuilder
	* @access 	protected
	*/
	protected	$queryBuilder;

	/**
	* @var 		$transaction
	* @access 	protected
	*/
	protected 	$transaction;

	/**
	* @access 	public
	* @return 	void
	*/
	public function __construct()
	{
		$connectionManager = new ConnectionManager();
		$provider = $connectionManager->getConnection('default');
		$this->transaction = $provider->transaction();
	}

	/**
	* Returns instance of query builder.
	*
	* @access 	public
	* @static
	* @return 	Object Glider\Query\Builder\QueryBuilder
	*/
	public static function getQueryBuilder()
	{
		return new QueryBuilder(new ConnectionManager());
	}

	/**
	* Returns a static instance of Glider\Factory.
	*
	* @access 	protected
	* @static
	* @return 	Object
	*/
	protected static function getInstance()
	{
		return new self();
	}

}