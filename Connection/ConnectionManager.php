<?php
namespace Glider\Connection;

use Str;
use Closure;
use Glider\ClassLoader;
use Glider\Configurator;
use Glider\Connection\DomainBag;
use Glider\Connection\Connector;
use Glider\Connection\ActiveConnection;
use Glider\Connection\ConnectionLoader;
use Glider\Connection\QueuedConnections;
use Glider\Connection\Contract\ConnectionInterface;
use Glider\Connectors\Contract\ConnectorProviderInterface;

class ConnectionManager implements ConnectionInterface
{
	
	/**
	* @var 		$connector
	* @access 	private
	*/
	private 	$connector;

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
	private static $connectionFailed = false;

	/**
	* @const 	DEFAULT_CONNECTION_ID
	*/
	const 		DEFAULT_CONNECTION_ID = 'default';

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
		if (!$this->canConnect($connectionId)) {
			return $this->reconnect($connectionId);
		}
	}

	/**
	* @param 	$id <String>
	* @access 	protected
	* @return 	Mixed
	*/
	protected function canConnect($id='')
	{
		if (!$this->fromQueue()->get($id)) {
			return false;
		}

		if ($this->configuredConnectionId !== '' && !isset($this->connections[$this->configuredConnectionId])) {
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

	}

	/**
	* {@inheritDoc}
	*/
	public function reconnect(String $id)
	{
		print '<pre>';
		print_r($this);
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
	* @param 	$connectionConfig <Array>
	* @access 	private
	* @return 	Boolean
	*/
	private function raiseChecks(array $connectionConfig=[])
	{

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

		if ($this->loadedConnections[$id]) {
			return new Connector();
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