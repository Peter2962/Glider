<?php
/**
* @package 	PlatformProvider
* @version 	0.1.0
*
* Platform provider interface for all available platforms
* registered. All platform providers must implement this interface.
*/

namespace Glider\Platform\Contract;

use Glider\Events\EventManager;
use Glider\Connection\PlatformResolver;
use Glider\Processor\Contract\ProcessorProvider;
use Glider\Connectors\Contract\ConnectorProvider;
use Glider\Transactions\Contract\TransactionProvider;
use Glider\Query\Builder\Contract\QueryBuilderProvider;

interface PlatformProvider
{

	/**
	* The constructor accepts two arguments: Glider\Connection\PlatformResolver which
	* passes the configuration to it and Glider\Events\EventManager which handles the
	* platform events.
	*
	* @param 	$platform Glider\Connection\PlatformResolver
	* @param 	$eventManager Glider\Events\EventManager	
	* @access 	public
	* @return 	void
	*/
	public function __construct(PlatformResolver $platformResolver, EventManager $eventManager);

	/**
	* The platform's connector provider that will be used to initialize
	* a connection with the database.
	*
	* @access 	public
	* @return 	Object Glider\Connectors\Contract\ConnectorProvider
	*/
	public function connector() : ConnectorProvider;

	/**
	* The platform's transaction provider that will be used to initialize
	* transactions while executing a query.
	*
	* @access 	public
	* @return 	Object Glider\Transaction\Contract\TransactionProvider
	*/
	public function transaction() : TransactionProvider;

	/**
	* The platform's processor provider that will be used to execute queries.
	*
	* @access 	public
	* @return 	Glider\Processor\Contract\ProcessorProvider
	*/
	public function processor() : ProcessorProvider;

	/**
	* The platform's query builder provider that will be used to build up
	* queries. Glider has a default query builder but we are doing this because
	* a platform might require a different query builder.
	* This method accepts an argument: Glider\Connectors\Contract\ConnectorProvider.
	*
	* @access 	public
	* @return 	Glider\Query\Builder\Contract\QueryBuilderProivder
	*/
	public function queryBuilder(ConnectorProvider $connectorProvider) : QueryBuilderProvider;

	/**
	* This method helps to check if a platform supports prepared statement
	* method of executing queries.
	* 
	* @access 	public
	* @return 	Boolean
	*/
	public function isPrepareCompatible() : Bool;

	/**
	* This method checks if a platform has a query method to execute queries.
	*
	* @access 	public
	* @return 	Boolean
	*/
	public function isQueryCompatible() : Bool;

	/**
	* This method checks if auto_commit is enabled in the configuration.
	*
	* @access 	public
	* @return 	Boolean
	*/
	public function isAutoCommitEnabled() : Bool;

	/**
	* Returns a configuraiton key if it exists. Returns null if it does not.
	*
	* @param 	$key <String>
	* @access 	public
	* @return 	Mixed
	*/
	public function getConfig(String $key=null);

}