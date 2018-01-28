<?php
/**
* MIT License
* Permission is hereby granted, free of charge, to any person obtaining a copy
* of this software and associated documentation files (the "Software"), to deal
* in the Software without restriction, including without limitation the rights
* to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
* copies of the Software, and to permit persons to whom the Software is
* furnished to do so, subject to the following conditions:

* The above copyright notice and this permission notice shall be included in all
* copies or substantial portions of the Software.

* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
* IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
* FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
* AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
* LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
* OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
* SOFTWARE.
*/

/**
* @package 	PlatformProvider
* @version 	0.1.0
*
* Platform provider interface for all available platforms
* registered. All platform providers must implement this interface.
*/

namespace Kit\Glider\Platform\Contract;

use StdClass;
use Kit\Glider\Events\EventManager;
use Kit\Glider\Connection\PlatformResolver;
use Kit\Glider\Processor\Contract\ProcessorProvider;
use Kit\Glider\Schema\Contract\SchemaManagerContract;
use Kit\Glider\Connectors\Contract\ConnectorProvider;
use Kit\Glider\Schema\Column\Contract\ColumnContract;
use Kit\Glider\Connection\Contract\ConnectionInterface;
use Kit\Glider\Transactions\Contract\TransactionProvider;
use Kit\Glider\Schema\Column\Index\Contract\IndexContract;
use Kit\Glider\Query\Builder\Contract\QueryBuilderProvider;

interface PlatformProvider
{

	/**
	* The constructor accepts two arguments: Kit\Glider\Connection\PlatformResolver which
	* passes the configuration to it and Kit\Glider\Events\EventManager which handles the
	* platform events.
	*
	* @param 	$platform Kit\Glider\Connection\PlatformResolver
	* @param 	$eventManager Kit\Glider\Events\EventManager	
	* @access 	public
	* @return 	void
	*/
	public function __construct(PlatformResolver $platformResolver, EventManager $eventManager);

	/**
	* The platform's connector provider that will be used to initialize
	* a connection with the database.
	*
	* @access 	public
	* @return 	Object Kit\Glider\Connectors\Contract\ConnectorProvider
	*/
	public function connector() : ConnectorProvider;

	/**
	* The platform's transaction provider that will be used to initialize
	* transactions while executing a query.
	*
	* @access 	public
	* @return 	Object Kit\Glider\Transaction\Contract\TransactionProvider
	*/
	public function transaction() : TransactionProvider;

	/**
	* The platform's processor provider that will be used to execute queries.
	*
	* @access 	public
	* @return 	Kit\Glider\Processor\Contract\ProcessorProvider
	*/
	public function processor() : ProcessorProvider;

	/**
	* Returns platform's schema manager.
	*
	* @param 	$connectionId <String>
	* @param 	$queryBuilder <Kit\Glider\Query\Builder\QueryBuilder>
	* @access 	public
	* @return 	Kit\Glider\Schema\Contract\SchemaManagerContract
	*/
	public function schemaManager(String $connectionId=null, QueryBuilderProvider $queryBuilder) : SchemaManagerContract;

	/**
	* The platform's query builder provider that will be used to build up
	* queries. Glider has a default query builder but we are doing this because
	* a platform might require a different query builder.
	* This method accepts an argument: Kit\Glider\Connection\Contract\ConnectionInterface.
	*
	* @param 	$connectionProvider <Kit\Glider\Connection\Contract\ConnectionInterface>
	* @param 	$connectionId <String>
	* @access 	public
	* @return 	Kit\Glider\Query\Builder\Contract\QueryBuilderProivder
	*/
	public function queryBuilder(ConnectionInterface $connectorProvider, String $connectionId=null) : QueryBuilderProvider;

	/**
	* Returns the platform's column class. Different platforms have different column
	* object definitions so using this will make it easy to control the column attributes.
	*
	* @access 	public
	* @return 	Kit\Glider\Schema\Column\Contract\ColumnContract
	*/
	public function column($column) : ColumnContract;

	/**
	* Returns the platform's index class.
	*
	* @access 	public
	* @return 	Kit\Glider\Schema\Column\Index\Contract\IndexContract
	*/
	public function columnIndex(StdClass $index) : IndexContract;

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