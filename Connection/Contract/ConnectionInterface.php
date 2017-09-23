<?php
namespace Glider\Connection\Contract;

use Str;
use Closure;

interface ConnectionInterface
{

	/**
	* Attempts to make a new connection.
	*
	* @param 	$withId <String>
	* @access 	public
	* @return 	Mixed
	*/
	public function reconnect(String $withId);

	/**
	* Returns a configured connection. Glider returns the default connection
	* if no id is provided.
	*
	* @param 	$id <String>
	* @access 	public
	* @return 	Mixed
	*/
	public function getConnection($id='');

	/**
	* Returns the id of the current connection.
	*
	* @access 	public
	* @return 	String
	*/
	public function getConnectionId();
	
	/**
	* Checks if a connection with the id @param $id exists.
	*
	* @param 	$id <String>
	* @access 	public
	* @return 	Boolean
	* @static
	*/
	public static function has(String $id);

	/**
	* Returns the current connection status.
	*
	* @access 	public
	* @return 	String
	* @static
	*/
	public static function getStatus();

	/**
	* Sometimes we might want to have different connection for different
	* domains. This method stores the registered domain connection
	* in the domain bag object.
	*
	* @param 	$domain <String>
	* @param 	$config <Closure>
	* @access 	public
	* @return 	void
	* @static
	*/
	public static function domain(String $domain, Closure $config);

	/**
	*
	* @param 	$id <String>
	* @param 	$settings <Closure>
	* @access 	public
	* @return 	void
	* @static
	*/
	public static function configure(String $id, Closure $settings);

}