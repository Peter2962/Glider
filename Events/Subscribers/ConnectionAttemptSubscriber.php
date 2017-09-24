<?php
namespace Glider\Events\Subscribers;

use Glider\Events\Contract\Subscriber;
use Glider\Exceptions\ConnectionFailedException;

class ConnectionAttemptSubscriber implements Subscriber
{

	/**
	* @var 		$message
	* @access 	private
	*/
	private 	$message;

	/**
	* @param 	$message <String>
	* @access 	public
	* @return 	void
	*/
	public function __construct($message='')
	{
		$this->message = $message;
	}

	/**
	* {@inheritDoc}
	*/
	public function getRegisteredEvents() : Array
	{
		return [
			'connect.failed' => 'throwError'
		];
	}

	/**
	* This method throws an exxeption on failed connection.
	*
	* @access 	public
	* @return 	void
	* @throws 	ConnectionFailedException
	*/
	public function throwError()
	{
		throw new ConnectionFailedException($this->message);
	}

}