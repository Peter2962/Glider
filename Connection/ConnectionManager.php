<?php
namespace Glider\Connection;

use Str;
use Closure;
use RuntimeException;
use Glider\ClassLoader;
use Glider\Configurator;
use Glider\Connection\DomainBag;
use Glider\Connection\PlatformResolver;
use Glider\Connection\ActiveConnection;
use Glider\Connection\ConnectionLoader;
use Glider\Connection\QueuedConnections;
use Glider\Connection\Contract\ConnectionInterface;
use Glider\Connectors\Contract\ConnectorProviderInterface;

class ConnectionManager implements ConnectionInterface
{
	
	/**
	* @var 		$platformConnector
	* @access 	private
	*/
	private 	$platformConnector;

	/**
	* @var 		$loadedConnections
	* @access 	private
	*/
	private 	$loadedConnections = [];

	/**
	* @var 		$badConnections
	* @access 	private
	*/
	private 	$badConnections = [];

	/**
	* @var 		$configuredConnectionId
	* @access 	private
	*/
	private 	$configuredConnectionId;

	/**
	* @var 		$loader
	* @access 	private
	*/
	private 	$loader;

	/**
	* @var 		$connectionFailed
	* @access 	private
	* @static
	*/
	private 	$connectionFailed = false;

	/**
	* @const 	DEFAULT_CONNECTION_ID
	*/
	const 		DEFAULT_CONNECTION_ID = 'default';

	/**
	* @const 	USE_ALT_KEY 	
	*/
	const 		USE_ALT_KEY = 'set_id_as_alternate_key';

	/**
	* @access 	public
	* @return 	void
	*/
	public function __construct()
	{
		$this->loader = new ClassLoader();
	}

	/**
	* Returns a connection.
	*
	* @param 	$connectionId <String>
	* @access 	public
	* @return 	Mixed
	*/
	public function getConnection($connectionId='')
	{
		// If we're not able to connect using the provided connection id,
		// we'll attempt to reconnect using the next provided connection id
		// the queue.
		return $this->canConnect($connectionId) || [];
	}

	/**
	* @param 	$id <String>
	* @access 	protected
	* @return 	Mixed
	*/
	protected function canConnect($id='')
	{
		if (!$this->fromQueue()->get($id)) {
			$this->connectionFailed = true;
			return false;
		}
	}

	/**
	* {@inheritDoc}
	*/
	public function getConnectionId()
	{
		return $this->configuredConnectionId;
	}

	/**
	* {@inheritDoc}
	*/
	public static function has(String $id)
	{
		return $this->fromQueue()->get($id);
	}

	/**
	* {@inheritDoc}
	*/
	public function getAlternativeId(String $id)
	{
		// If no id is provided, we will try to reconnect with the default
		// connection id.
		if (empty($id)) {
			$id = ConnectionManager::DEFAULT_CONNECTION_ID;
		}

		if (!in_array($id, array_keys($this->loadedConnections)) && $id !== ConnectionManager::USE_ALT_KEY) {
			throw new RuntimeException('Cannot initialize a reconnection.');
		}

		$loaded = $this->loadedConnections;
		$nextKey = ConnectionManager::USE_ALT_KEY;
		$failedId = $this->getConnectionId();

		if (isset($loaded[$failedId]['alt']) && isset($loaded[$loaded[$failedId]['alt']])) {
			return [$loaded[$failedId]['alt'] => $loaded[$loaded[$failedId]['alt']]];
		}

		return null;		
	}

	/**
	* {@inheritDoc}
	*/
	public static function domain(String $domain, Closure $settings)
	{

	}

	/**
	* {@inheritDoc}
	*/
	public static function getStatus()
	{
		return ActiveConnection::status();
	}

	/**
	* @access 	private
	* @return 	Glider\Connection\QueuedConnections
	*/
	private function queue() : QueuedConnections {
		return new QueuedConnections();
	}

	/**
	* {@inheritDoc}
	*/
	public static function configure(String $id, Closure $settings)
	{
		$configInstance = new Configurator($id);
		self::instance()->loader->callClassMethod($configInstance, 'attachConfiguration', $settings);
	}

	/**
	* @param 	$event <Array>
	* @access 	private
	* @return 	Boolean
	*/
	private function raiseEvent(array $event=[])
	{
		return null;
	}

	/**
	* @access 	private
	* @return 	Glider\ConnectionManager
	*/
	private function fromQueue() : ConnectionManager
	{
		$this->loadedConnections = $this->loader->callClassMethod($this->queue(), 'getQueued');
		return $this;
	}

	/**
	* Try to connection with this id from the loaded connections in the configuration
	* file.
	*
	* @param 	$id <String>
	* @access 	private
	* @return 	Mixed
	*/
	private function get(String $id)
	{
		if (!$id) {
			$id = ConnectionManager::DEFAULT_CONNECTION_ID;
		}

		if (count($this->loadedConnections) < 1) {
			return false;
		}

		if (isset($this->loadedConnections[$id])) {
			$this->configuredConnectionId = $id;
			$this->platformConnector = [$id => $this->loadedConnections[$id]];
			$connector = new PlatformResolver($this);
			return $connector->resolvePlatform();
		}
	}

	/**
	* @access 	public
	* @final
	* @return 	Object
	* @static
	*/
	final private static function instance()
	{
		return new self();
	}

}