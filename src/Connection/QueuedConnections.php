<?php
namespace Kit\Glider\Connection;

use Kit\Glider\Configurator;
use Kit\Glider\Connection\ConnectionLoader;

class QueuedConnections
{

	private static $connections = [];

	/**
	* Returns an array of queued connections.
	*
	* @param 	$connectionLoader Kit\Glider\Connection\ConnectionLoader
	* @access 	public
	* @final
	* @return 	Array
	*/
	final public function getQueued(ConnectionLoader $connectionLoader) : Array
	{
		return $connectionLoader->getConnectionsFromResource();
	}

	/**
	* @access 	public
	* @return 	Object
	* @final
	* @static
	*/
	final public static function instance()
	{
		return new self();
	}

}