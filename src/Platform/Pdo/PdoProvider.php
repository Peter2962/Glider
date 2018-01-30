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
* @author 	Peter Taiwo
*/

####################
# Pdo Provider class
####################

namespace Kit\Glider\Platform\Pdo;

use StdClass;
use Kit\Glider\Events\EventManager;
use Kit\Glider\Processor\Pdo\PdoProcessor;
use Kit\Glider\Query\Builder\QueryBuilder;
use Kit\Glider\Connectors\Pdo\PdoConnector;
use Kit\Glider\Connection\PlatformResolver;
use Kit\Glider\Transactions\Pdo\PdoTransaction;
use Kit\Glider\Schema\Platforms\PdoSchemaManager;
use Kit\Glider\Platform\Contract\PlatformProvider;
use Kit\Glider\Processor\Contract\ProcessorProvider;
use Kit\Glider\Schema\Contract\SchemaManagerContract;
use Kit\Glider\Connectors\Contract\ConnectorProvider;
use Kit\Glider\Schema\Column\Contract\ColumnContract;
use Kit\Glider\Query\Builder\Platforms\PdoQueryBuilder;
use Kit\Glider\Connection\Contract\ConnectionInterface;
use Kit\Glider\Transactions\Contract\TransactionProvider;
use Kit\Glider\Schema\Column\Index\Contract\IndexContract;
use Kit\Glider\Query\Builder\Contract\QueryBuilderProvider;

class PdoProvider implements PlatformProvider
{

	/**
	* @var 		$config
	* @access 	private
	*/
	private 	$config;

	/**
	* @var 		$eventManager
	* @access 	private
	*/
	public 		$eventManager;

	/**
	* {@inheritDoc}
	*/
	public function __construct(PlatformResolver $platform, EventManager $eventManager)
	{
		$this->config = $platform->preparedConnection();
		$this->eventManager = $eventManager;
	}

	/**
	* {@inheritDoc}
	*/
	public function connector() : ConnectorProvider
	{
		return new PdoConnector($this);
	}

	/**
	* {@inheritDoc}
	*/
	public function transaction() : TransactionProvider
	{
		return new PdoTransaction($this);
	}

	/**
	* {@inheritDoc}
	*/
	public function processor() : ProcessorProvider
	{
		return new PdoProcessor($this);
	}

	/**
	* We're using pdo query builder.
	*
	* {@inheritDoc}
	*/
	public function queryBuilder(ConnectionInterface $connection, String $connectionId=null) : QueryBuilderProvider
	{
		return new PdoQueryBuilder($connection, $connectionId);
	}

	/**
	* {@inheritDoc}
	*/
	public function schemaManager(String $connectionId=null, QueryBuilderProvider $queryBuilder) : SchemaManagerContract
	{
		return new PdoSchemaManager($connectionId, $queryBuilder);
	}

	/**
	* {@inheritDoc}
	*/
	public function column($column) : ColumnContract
	{

	}

	/**
	* {@inheritDoc}
	*/
	public function columnIndex(StdClass $index) : IndexContract
	{

	}

	/**
	* {@inheritDoc}
	*/
	public function isPrepareCompatible() : Bool
	{
		return true;
	}

	/**
	* {@inheritDoc}
	*/
	public function isQueryCompatible() : Bool
	{
		return true;
	}

	/**
	* {@inheritDoc}
	*/
	public function isAutoCommitEnabled() : Bool
	{
		return ($this->getConfig('auto_commit') == true) ? true : false;
	}

	/**
	* {@inheritDoc}
	*/
	final public function getConfig(String $key=null)
	{
		return $this->config[$key] ?? null;
	}

	/**
	* {@inheritDoc}
	*/
	final public function getPlatformName() : String
	{
		return 'PDO';
	}

}