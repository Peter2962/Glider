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

use Glider\Schema\SchemaManager;
use Glider\Query\Builder\QueryBinder;
use Glider\Query\Builder\QueryBuilder;
use Glider\Connection\ConnectionManager;
use Glider\Platform\Contract\PlatformProvider;
use Glider\Schema\Contract\SchemaManagerContract;

class Factory
{

	/**
	* @var 		$provider
	* @access 	protected
	* @static
	*/
	protected static $provider;

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
	public function __construct(String $connection=null)
	{
		$connectionManager = new ConnectionManager();
		Factory::$provider = $provider = $connectionManager->getConnection($connection);
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
		return new QueryBuilder(new ConnectionManager(), Factory::$provider);
	}

	/**
	* Returns instance of SchemaManager.
	*
	* @param 	$connectionId <String>
	* @access 	public
	* @return 	Glider\Schema\SchemaManager\SchemaManagerContract
	*/
	public static function getSchema(String $connectionId=null) : SchemaManagerContract
	{
		return new SchemaManager($connectionId);
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