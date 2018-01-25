<?php
namespace Kit\Glider\Connection;

use StdClass;
use ReflectionClass;
use RuntimeException;
use Kit\Glider\Connection\Domain;
use Kit\Glider\Events\EventManager;
use Kit\Glider\Events\Contract\Subscriber;
use Kit\Glider\Connection\ConnectionManager;
use Kit\Glider\Platform\Contract\PlatformProvider;
use Kit\Glider\Connectors\Contract\ConnectorProvider;
use Kit\Glider\Connection\Contract\ConnectionInterface;
use Kit\Glider\Events\Subscribers\ConnectionAttemptSubscriber;

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
	* @param 	$contract Kit\Glider\Connectors\Contract\ConnectionInterface
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
	* @param 	$eventManager Kit\Glider\Events\EventManager
	* @access 	public
	* @return 	Object Kit\Glider\Platform\Contract\PlatformProvider
	*/
	public function resolvePlatform(EventManager $eventManager)
	{
		$eventManager->attachSubscriber(new ConnectionAttemptSubscriber());

		if (!$this->connectionManager instanceof ConnectionInterface) {
			throw new RuntimeException('Connection must implement \ConnectionInterface');
		}

		$reflector = new \ReflectionClass($this->connectionManager);
		$connections = $reflector->getProperty('platformConnector');
		$connections->setAccessible('public');
		$connections = $connections->getValue($this->connectionManager);
		$resolvedProvider = $this->getPlatformProvider($connections, $eventManager);

		if (!$resolvedProvider) {
			$resolvedProvider = $this->getPlatformProvider(
				$this->connectionManager->getAlternativeId(ConnectionManager::USE_ALT_KEY), $eventManager
			);
		}

		if (!is_null($resolvedProvider) && $resolvedProvider == false) {
			throw new RuntimeException('Unable to resolve database platform.');
		}

		// If connection was successfully established, dispatch `connect.created` event.
		$this->platformProvider->eventManager->dispatchEvent('connect.created');
		return $resolvedProvider;
	}

	/**
	* Resolves a connector's provider and returns it's object.
	*
	* @param 	$eventManager Kit\Glider\Events\EventManager 	
	* @param 	$platform <Array>
	* @access 	private
	* @return 	Mixed
	*/
	private function getPlatformProvider($platform=[], EventManager $eventManager)
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
		$platformProvider = new $provider($this, new EventManager());
		if (!$platformProvider instanceof PlatformProvider) {
			return false;
		}

		if (isset($platform['domain']) && !Domain::matches($platform['domain'])) {
			$eventManager->dispatchEvent('domain.notallowed', [$platformId => $platform]);
			return false;
		}

		$this->platformProvider = $platformProvider;
		$providerConnector = $this->platformProvider;
		return $providerConnector;
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

	/**
	* {@inheritDoc}
	*/
	public static function getRegisteredEvents() : Array
	{
		return [];
	}

}