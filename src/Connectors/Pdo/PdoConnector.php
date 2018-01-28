<?php
###############################
# PDO database connection class 
###############################

namespace Kit\Glider\Connectors\Pdo;

use PDO;
use StdClass;
use PDOException;
use Kit\Glider\Events\EventManager;
use Kit\Glider\Events\Contract\Subscriber;
use Kit\Glider\Platform\Contract\PlatformProvider;
use Kit\Glider\Connectors\Contract\ConnectorProvider;
use Kit\Glider\Events\Subscribers\ConnectionAttemptSubscriber;

class PdoConnector implements ConnectorProvider
{

	/**
	* @var 		$platform
	* @access 	private
	*/
	private 	$platform;

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
	public function __construct(PlatformProvider $platform)
	{
		$this->platform = $platform;
	}

	/**
	* {@inheritDoc}
	*/
	public function connect(String $host=null, String $username=null, String $password=null, String $database=null, String $collation=null, String $charset=null) {
		
		$connection = new StdClass;
		$host = $host == null ? $this->platform->getConfig('host') : $host;
		$username = $username == null ? $this->platform->getConfig('username') : $username;
		$password = $password == null ? $this->platform->getConfig('password') : $password;
		$database = $database == null ? $this->platform->getConfig('database') : $database;
		$collation = $collation == null ? $this->platform->getConfig('collation') : $collation;
		$charset = $charset == null ? $this->platform->getConfig('charset') : $charset;
		
		$persistent = (
			$this->platform->getConfig('persistent') &&
				is_bool($this->platform->getConfig('persistent'))
			) ? $this->platform->getConfig('persistent') : true;

		$dsn = 'mysql:dbname=' . $database . ';' . 'host=' . $host;

		if ($this->platform->getConfig('charset')) {
			$dsn .= ';charset=' . $this->platform->getConfig('charset');
		}

		$pdo = new PDO($dsn, $username, $password);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$pdo->setAttribute(PDO::ATTR_CASE, PDO::CASE_NATURAL);
		$pdo->setAttribute(PDO::ATTR_PERSISTENT, $persistent);

	}

	/**
	* {@inheritDoc}
	*/
	public function getErrorMessage($connection=null)
	{
		if (!$connection instanceof PDO) {
			$this->platform->eventManager->dispatchEvent('connect.failed.message.instance', 'pdo');
		}
	}

	/**
	* {@inheritDoc}
	*/
	public function getErrorNumber($connection=null)
	{
		if (!$connection instanceof PDO) {
			$this->platform->eventManager->dispatchEvent('connect.failed.number.instance', 'pdo');
		}
	}

}