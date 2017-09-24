<?php
namespace Glider\Connectors\Mysqli;

use mysqli;
use StdClass;
use Glider\Events\EventManager;
use Glider\Events\Contract\Subscriber;
use Glider\Platform\Contract\PlatformProvider;
use Glider\Connectors\Contract\ConnectorProvider;
use Glider\Events\Subscribers\ConnectionAttemptSubscriber;

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
	* @var 		$hasError
	* @access 	private
	*/
	public static $hasError = false;

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
	public function connect(String $host=null, String $username=null, String $password=null, String $database=null)
	{
		$connection = new StdClass;
		$host = $host == null ? $this->platformProvider->getConfig('host') : $host;
		$username = $username == null ? $this->platformProvider->getConfig('username') : $username;
		$password = $password == null ? $this->platformProvider->getConfig('password') : $password;
		$database = $database == null ? $this->platformProvider->getConfig('database') : $database;

		$connection = new mysqli($host, $username, $password, $database);

		// If there is an error establishing a connection, attach the `ConnectionAttemptSubscriber` to
		// the event manager to dispatch.
		if ($connection->connect_error) {
			$this->platformProvider->eventManager->attachSubscriber(new ConnectionAttemptSubscriber($connection->connect_error));
		}

		// If `collation` is set in the configuration or we are able to get it from
		// the platform provider, we will make an attempt to set the collation to the
		// configuration value.
		if ($this->platformProvider->getConfig('collation')) {

		}

		// If `charset` is set in the configuration just like the `collation`,
		// we will make an attempt to set it as well.
		if ($this->platformProvider->getConfig('charset')) {

		}

		$this->connection = $connection;
		return $this->connection;
	}

}