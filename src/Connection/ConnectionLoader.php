<?php
namespace Kit\Glider\Connection;

use Exception;

class ConnectionLoader
{

	/**
	* @access 	public
	* @return 	Array
	*/
	public function getConnectionsFromResource() : Array
	{
		if (!file_exists('Config.php')) {

			throw new Exception('Unable to load database configuration file.');

		}

		$resourceConfig = include 'Config.php';
		
		if (gettype($resourceConfig) !== 'array') {

			throw new Exception('Invalid configuration type.');
		
		}
		
		return $resourceConfig;
	}

	public static function getGroupedConnections()
	{

	}

}