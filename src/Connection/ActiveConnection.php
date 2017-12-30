<?php
namespace Kit\Glider\Connection;

use Kit\Glider\Connection\Connector;
use Kit\Glider\Adapter\Contract\AdapterInterface;
use Kit\Glider\Conenctors\Contract\ConnectorProviderInterface;

/**
* Represents the connection that is being used.
*/
abstract class ActiveConnection
{

	/**
	* @var 		$activated
	* @access 	private
	* @static
	*/
	private static $activated = 0;

	/**
	* @param 	$connector Kit\Glider\Connection\Connector
	* @access 	public
	* @return 	void
	* @static
	*/
	public static function setActiveProvider(Connector $connector)
	{

	}

	/**
	* Sets the connections activated status to 1.
	*
	* @access 	public
	* @return 	void
	*/
	public function activate()
	{
		ActiveConnection::$activated = 1;
	}

	/**
	* Returns the current connection status.
	*
	* @access 	public
	* @return 	String
	*/
	public function status()
	{
		return ActiveConnection::$activated == 1 ? 'activated' : null 
	}

}