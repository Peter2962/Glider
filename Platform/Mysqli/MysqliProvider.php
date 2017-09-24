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
	* The constructor accepts an argument
	*
	*
	*/
	public function __construct()
	{

	}

	public function connector() : ConnectorProvider
	{
		return new MysqliConnector();
	}

}