<?php
/**
* @package 	Factory
* @version 	0.1.0
*
* This factory handles all database operations provided by
* Glider. The connection manager @see Kit\Glider\Connection\ConnectionManager can also
* be used to handle some operations.
*/

namespace Kit\Glider;

use Kit\Glider\Schema\SchemaManager;
use Kit\Glider\Query\Builder\QueryBinder;
use Kit\Glider\Query\Builder\QueryBuilder;
use Kit\Glider\Connection\ConnectionManager;
use Kit\Glider\Platform\Contract\PlatformProvider;
use Kit\Glider\Schema\Column\Contract\ColumnContract;
use Kit\Glider\Schema\Contract\SchemaManagerContract;

class Factory
{

	/**
	* @var 		$provider
	* @access 	protected
	* @static
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
	public function __construct(String $connection=null)
	{
		$connectionManager = new ConnectionManager();
		$this->provider = $provider = $connectionManager->getConnection($connection);
		$this->transaction = $provider->transaction();
	}

	/**
	* Returns instance of query builder.
	*
	* @access 	public
	* @static
	* @return 	Object Kit\Glider\Query\Builder\QueryBuilder
	*/
	public static function getQueryBuilder()
	{
		return self::getInstance()->provider->queryBuilder(new ConnectionManager());
	}

	/**
	* Returns instance of SchemaManager.
	*
	* @param 	$connectionId <String>
	* @access 	public
	* @static
	* @return 	Kit\Glider\Schema\SchemaManager\SchemaManagerContract
	*/
	public static function getSchema(String $connectionId=null) : SchemaManagerContract
	{
		return self::getInstance()->provider->schemaManager($connectionId, Factory::getQueryBuilder());
	}

	/**
	* Returns current provider.
	*
	* @access 	public
	* @static
	* @return Kit\Glider\Platform\Contract\PlatformProvider
	*/
	public static function getProvider() : PlatformProvider
	{
		return self::getInstance()->provider;
	}

	/**
	* Returns the platform column class.
	*
	* @param 	$column <Object>
	* @access 	public
	* @static
	* @return 	Kit\Glider\Schema\Column\Contract\ColumnContract
	*/
	public static function getPlatformColumn($column) : ColumnContract
	{
		return self::getInstance()->provider->column($column);
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