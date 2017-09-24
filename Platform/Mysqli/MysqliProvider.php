<?php
namespace Glider\Platform\Mysqli;

use Glider\Connection\PlatformResolver;
use Glider\Connectors\Mysqli\MysqliConnector;
use Glider\Platform\Contract\PlatformProvider;
use Glider\Connectors\Contract\ConnectorProvider;

class MysqliProvider implements PlatformProvider
{

	/**
	* @var 		$config
	* @access 	private
	*/
	private 	$config;

	/**
	* {@inheritDoc}
	*/
	public function __construct(PlatformResolver $platform)
	{
		$this->config = $platform->preparedConnection();
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
	final public function getConfig(String $key=null)
	{
		return $this->config[$key] ?? null;
	}

}