<?php
namespace Glider\Connection;

use Glider\Connection\ConnectionManager;

class Connector
{

	/**
	* @var 		$connection
	* @access 	private
	*/
	private 	$connection;

	public function __construct()
	{
		$connection = new ConnectionManager($this);
		$this->connection = $connection;
		return true;
	}

}