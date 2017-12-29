<?php
namespace Glider\Connection;

class ConnectionLoader
{

	/**
	* @access 	public
	* @return 	Array
	*/
	public function getConnectionsFromResource() : Array
	{
		if (!file_exists('Config.php')) {
			return [];
		}

		$resourceConfig = include 'Config.php';
		if (gettype($resourceConfig) !== 'array') {
			return [];
		}
		
		return $resourceConfig;
	}

	public static function getGroupedConnections()
	{

	}

}