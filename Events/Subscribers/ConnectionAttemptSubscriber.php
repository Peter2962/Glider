<?php
namespace Glider\Events\Subscribers;

use Glider\Events\Contract\Subscriber;
use Glider\Exceptions\ConnectionFailedException;

class ConnectionAttemptSubscriber implements Subscriber
{

	/**
	* @var 		$connection
	* @access 	private
	*/
	private 	$connection;

	/**
	* @param 	$connection <String>
	* @access 	public
	* @return 	void
	*/
	public function __construct($connection='')
	{
		$this->connection = $connection;
	}

	/**
	* {@inheritDoc}
	*/
	public function getRegisteredEvents() : Array
	{
		return [
			'connect.failed' => 'onConnectionFailed',
			'connect.created' => 'onConnectionCreated'
		];
	}

	/**
	* This method throws an exxeption on failed connection.
	*
	* @access 	public
	* @return 	void
	* @throws 	ConnectionFailedException
	*/
	public function onConnectionFailed()
	{
		throw new ConnectionFailedException($this->connection->connect_error);
	}

	/**
	* This method is called after a connection has been successfully created.
	*
	* @access 	public
	* @return 	void
	* @throws 	ConnectionFailedException
	*/
	public function onConnectionCreated()
	{
		//
	}

}