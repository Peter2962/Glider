<?php
namespace Kit\Glider\Events\Subscribers;

use RuntimeException;
use InvalidArgumentException;
use Kit\Glider\Events\Contract\Subscriber;
use Kit\Glider\Exceptions\ConnectionFailedException;

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
			'connect.created' => 'onConnectionCreated',
			'domain.notallowed' => 'domainNotAllowed',
			'connect.failed.message.instance' => 'onGenerateErrorMessage',
			'connect.failed.number.instance' => 'onGenerateErrorNumber'
		];
	}

	/**
	* This method throws an exxeption on failed connection.
	*
	* @param 	$message <String>
	* @access 	public
	* @return 	void
	* @throws 	ConnectionFailedException
	*/
	public function onConnectionFailed(String $message)
	{	
		throw new ConnectionFailedException($message);
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

	/**
	* This method throws an exception if an attempt is made to connect to the
	* on the domain that is not specified in the configuration file.
	*
	* @param 	$configuration <Array>
	* @access 	public
	* @return 	void
	* @throws 	RuntimeException
	*/
	public function domainNotAllowed(Array $configuration)
	{
		$connectionName = '';
		if (key($configuration)) {
			$connectionName = key($configuration);
		}

		throw new RuntimeException(sprintf(
			"Connection not allowed for domain {%s} in {%s} configuration.", array_values($configuration)[0]['domain'], $connectionName)
		);
	}

	/**
	* This method throws an exception if a platform's error message is being generated
	* and the provided parameter is not the required instance.
	*
	* @param 	$instanceName <String>
	* @access 	public
	* @return 	void
	*/
	public function onGenerateErrorMessage(String $instanceName)
	{
		throw new InvalidArgumentException(sprintf(
			"Cannot retrieve error message. Instance of {%s} is required.", $instanceName)
		);
	}

	/**
	* This method throws an exception if a platform's error number is being generated
	* and the provided parameter is not the required instance.
	*
	* @param 	$instanceName <String>
	* @access 	public
	* @return 	void
	*/
	public function onGenerateErrorNumber(String $instanceName)
	{
		throw new InvalidArgumentException(sprintf(
			"Cannot retrieve error number. Instance of {%s} is required.", $instanceName)
		);
	}

}