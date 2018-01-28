<?php
/**
* @package 	Repository
* @version 	0.1.0
*
* This Repository handles all database operations provided by
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

class Repository
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
	* @var 		$connectionId
	* @access 	protected
	*/
	protected 	$connectionId;

	/**
	* @param 	$connectionId <String>
	* @access 	public
	* @return 	void
	*/
	public function __construct(String $connectionId=null)
	{
		$this->connectionId = $connectionId;
		$connectionManager = new ConnectionManager();
		$this->provider = $provider = $connectionManager->getConnection($this->connectionId);
		$this->transaction = $provider->transaction();
	}

	/**
	* Returns instance of query builder.
	*
	* @param 	$connectionId <String>
	* @access 	public
	* @static
	* @return 	Object Kit\Glider\Query\Builder\QueryBuilder
	*/
	public static function getQueryBuilder(String $connectionId=null)
	{
		return self::getInstance($connectionId)->provider->queryBuilder(new ConnectionManager(), $connectionId);
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
		return self::getInstance($connectionId)->provider->schemaManager($connectionId, Repository::getQueryBuilder($connectionId));
	}

	/**
	* Returns current provider.
	*
	* @param 	$connectionId <String>
	* @access 	public
	* @static
	* @return Kit\Glider\Platform\Contract\PlatformProvider
	*/
	public static function getProvider(String $connectionId=null) : PlatformProvider
	{
		return self::getInstance($connectionId)->provider;
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
	* Returns a static instance of Kit\Glider\Repository.
	*
	* @param 	$connectionId <String>
	* @access 	protected
	* @static
	* @return 	Object
	*/
	protected static function getInstance(String $connectionId=null)
	{
		return new self($connectionId);
	}

}