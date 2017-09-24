<?php
/**
* @package 	Factory
* @version 	0.1.0
*
* This factory handles all database operations provided by
* Glider. The connection manager @see Glider\Connection\ConnectionManager can also
* be used to handle some operations.
*/

namespace Glider;

use Glider\Connection\ConnectionManager;

class Factory
{

	/**
	* @var 		$connection
	* @access 	protected
	*/
	protected 	$connection;

	/**
	* @param 	$connection Glider\Connection\ConnectionManager
	* @access 	public
	* @return 	void
	*/
	public function __construct()
	{
		$connectionManager = new ConnectionManager();
		$this->connection = $connectionManager->getConnection();
	}

}