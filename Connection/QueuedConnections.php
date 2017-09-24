<?php
namespace Glider\Connection;

use Glider\Configurator;
use Glider\Connection\ConnectionLoader;

class QueuedConnections
{

	private static $connections = [];

	/**
	* Returns an array of queued connections.
	*
	* @param 	$connectionLoader Glider\Connection\ConnectionLoader
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