<?php
namespace Kit\Glider\Platform\Mysqli;

use StdClass;
use Kit\Glider\Events\EventManager;
use Kit\Glider\Query\Builder\QueryBuilder;
use Kit\Glider\Connection\PlatformResolver;
use Kit\Glider\Schema\Column\Index\MysqliIndex;
use Kit\Glider\Processor\Mysqli\MysqliProcessor;
use Kit\Glider\Connectors\Mysqli\MysqliConnector;
use Kit\Glider\Platform\Contract\PlatformProvider;
use Kit\Glider\Schema\Column\Platform\MysqliColumn;
use Kit\Glider\Processor\Contract\ProcessorProvider;
use Kit\Glider\Schema\Platforms\MysqliSchemaManager;
use Kit\Glider\Schema\Contract\SchemaManagerContract;
use Kit\Glider\Transactions\Mysqli\MysqliTransaction;
use Kit\Glider\Connectors\Contract\ConnectorProvider;
use Kit\Glider\Schema\Column\Contract\ColumnContract;
use Kit\Glider\Connection\Contract\ConnectionInterface;
use Kit\Glider\Transactions\Contract\TransactionProvider;
use Kit\Glider\Schema\Column\Index\Contract\IndexContract;
use Kit\Glider\Query\Builder\Contract\QueryBuilderProvider;

class MysqliProvider implements PlatformProvider
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
		return new MysqliConnector($this);
	}

	/**
	* {@inheritDoc}
	*/
	public function transaction() : TransactionProvider
	{
		return new MysqliTransaction($this);
	}

	/**
	* {@inheritDoc}
	*/
	public function processor() : ProcessorProvider
	{
		return new MysqliProcessor($this);
	}

	/**
	* We're using the default query builder.
	*
	* {@inheritDoc}
	*/
	public function queryBuilder(ConnectionInterface $connection) : QueryBuilderProvider
	{
		return new QueryBuilder($connection);
	}

	/**
	* {@inheritDoc}
	*/
	public function schemaManager(String $connectionId=null, QueryBuilderProvider $queryBuilder) : SchemaManagerContract
	{
		return new MysqliSchemaManager($connectionId, $queryBuilder);
	}

	/**
	* {@inheritDoc}
	*/
	public function column($column) : ColumnContract
	{
		return new MysqliColumn($column);
	}

	/**
	* {@inheritDoc}
	*/
	public function columnIndex(StdClass $index) : IndexContract
	{
		return new MysqliIndex($index);
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