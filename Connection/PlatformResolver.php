<?php
namespace Glider\Connection;

use StdClass;
use ReflectionClass;
use RuntimeException;
use Glider\Connection\Domain;
use Glider\Connection\ConnectionManager;
use Glider\Platform\Contract\PlatformProvider;
use Glider\Connectors\Contract\ConnectorProvider;
use Glider\Connection\Contract\ConnectionInterface;

class PlatformResolver
{

	/**
	* @var 		$connection
	* @access 	private
	*/
	private 	$connection;

	/**
	* @var 		$connectionManager
	* @access 	private
	*/
	private 	$connectionManager;

	/**
	* @var 		$connectionFailed
	* @access 	private
	*/
	private 	$connectonFailed;

	/**
	* @var 		$platformProvider
	* @access 	private
	*/
	private 	$platformProvider;

	/**
	* @var 		$preparedConnection
	* @access 	private
	*/
	private 	$preparedConnection;

	/**
	* @param 	$contract Glider\Connectors\Contract\ConnectionInterface
	* @access 	public
	* @return 	void
	*/
	public function __construct(ConnectionInterface $contract)
	{
		$this->connectionManager = $contract;
		$this->connection = null;
		$this->connectionFailed = false;
	}

	/**
	* Resolve provided connection's platform.
	*
	* @access 	public
	* @return 	Object
	*/
	public function resolvePlatform()
	{
		if (!$this->connectionManager instanceof ConnectionInterface) {
			throw new RuntimeException('Connection must implement \ConnectionInterface');
		}
		$reflector = new \ReflectionClass($this->connectionManager);
		$connections = $reflector->getProperty('platformConnector');
		$connections->setAccessible('public');
		$connections = $connections->getValue($this->connectionManager);
		$resolvedConnection = null;

		if ($this->getPlatformProvider($connections) == false) {
			$resolvedConnection = $this->getPlatformProvider($this->connectionManager->getAlternativeId(ConnectionManager::USE_ALT_KEY));
		}

		if (!is_null($resolvedConnection) && $resolvedConnection == false) {
			throw new RuntimeException('Unable to start connection for database platform.');
		}
		return false;
	}

	/**
	* Resolves a connector's provider and returns it's object.
	*
	* @param 	$platform <Array>
	* @access 	private
	* @return 	Mixed
	*/
	private function getPlatformProvider($platform=[])
	{	
		if (is_null($platform)) {
			return false;
		}

		$platformId = key($platform);
		$platform = current($platform);
		if (!isset($platform['provider'])) {
			$this->connectionFailed = ':noPlatform';
			return false;
		}

		$provider = $platform['provider'];
		if (!class_exists($provider)) {
			$this->connectionFailed = ':noConnectorProvider';
			return false;
		}

		$this->preparedConnection = $platform;
		$platformProvider = new $provider($this);
		if (!$platformProvider instanceof PlatformProvider) {
			return false;
		}

		if (isset($platform['domain']) && !Domain::matches($platform['domain'])) {
			return false;
		}

		$this->platformProvider = $platformProvider;
		$providerConnector = $this->platformProvider->connector();
		return $providerConnector->connect();
	}

	/**
	* Returns the resolved connection configuration.
	*
	* @access 	public
	* @final
	* @return 	Array
	*/
	final public function preparedConnection()
	{
		return $this->preparedConnection;
	}

}