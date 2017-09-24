<?php
namespace Glider\Connectors\Mysqli;

use StdClass;
use Glider\Platform\Contract\PlatformProvider;
use Glider\Connectors\Contract\ConnectorProvider;

class MysqliConnector implements ConnectorProvider
{

	/**
	* @var 		$platformProvider
	* @access 	private
	*/
	private 	$platformProvider;

	/**
	* @var 		$connection
	* @access 	private
	*/
	private 	$connection;

	/**
	* {@inheritDoc}
	*/
	public function __construct(PlatformProvider $platformProvider)
	{
		$this->platformProvider = $platformProvider;
	}

	/**
	* {@inheritDoc}
	*/
	public function connect(String $host=null, String $username=null, String $password=null)
	{
		$connection = new StdClass;
		$host = $host == null ? $this->platformProvider->getConfig('host') : $host;
		$username = $username == null ? $this->platformProvider->getConfig('username') : $username;
		$password = $password == null ? $this->platformProvider->getConfig('password') : $password;

		return $connection;
	}

}