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
		$baseDir = dirname(__DIR__);
		$configLocation = $baseDir . '/Config.php';
	
		if (!file_exists($configLocation)) {

			throw new Exception('Unable to load database configuration file.');

		}

		$resourceConfig = include $configLocation;

		if (gettype($resourceConfig) !== 'array') {

			throw new Exception('Invalid configuration type.');
		
		}
		
		return $resourceConfig;
	}

	public static function getGroupedConnections()
	{
		//
	}

}