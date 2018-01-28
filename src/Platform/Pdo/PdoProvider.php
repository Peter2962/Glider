<?php
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
	* We're using the default query builder.
	*
	* {@inheritDoc}
	*/
	public function queryBuilder(ConnectionInterface $connection, String $connectionId=null) : QueryBuilderProvider
	{
		return new QueryBuilder($connection, $connectionId);
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

}