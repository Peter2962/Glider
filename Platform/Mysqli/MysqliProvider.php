<?php
namespace Glider\Platform\Mysqli;

use Glider\Events\EventManager;
use Glider\Query\Builder\QueryBuilder;
use Glider\Connection\PlatformResolver;
use Glider\Connectors\Mysqli\MysqliConnector;
use Glider\Platform\Contract\PlatformProvider;
use Glider\Transactions\Mysqli\MysqliTransaction;
use Glider\Connectors\Contract\ConnectorProvider;
use Glider\Transactions\Contract\TransactionProvider;
use Glider\Query\Builder\Contract\QueryBuilderProvider;

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
	* We're using the default query builder.
	*
	* {@inheritDoc}
	*/
	public function queryBuilder(ConnectorProvider $connectorProvider) : QueryBuilderProvider
	{
		return new QueryBuilder($connectorProvider);
	}

	/**
	* {@inheritDoc}
	*/
	final public function getConfig(String $key=null)
	{
		return $this->config[$key] ?? null;
	}

}