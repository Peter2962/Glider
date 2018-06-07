<?php
/**
* @author 		Peter Taiwo <peter@phoxphp.com>
* @package 		Kit\Glider\Events\Subscribers\ConnectionAttemptSubscriber
* @license 		MIT License
*
* Permission is hereby granted, free of charge, to any person obtaining a copy
* of this software and associated documentation files (the "Software"), to deal
* in the Software without restriction, including without limitation the rights
* to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
* copies of the Software, and to permit persons to whom the Software is
* furnished to do so, subject to the following conditions:
*
* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
* IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
* FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
* AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
* LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
* OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
* SOFTWARE.
*/

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
	* @return 	<void>
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
	* @return 	<void>
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
	* @return 	<void>
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
	* @return 	<void>
	* @throws 	RuntimeException
	*/
	public function domainNotAllowed(Array $configuration)
	{
		$connectionName = '';
		$config = array_values($configuration)[0];

		if (key($configuration)) {
			$connectionName = key($configuration);
		}

		if (is_array($config['domain'])) {
			if (sizeof($config['domain']) > 1) {
				$errorReport = sprintf(
					"Connection not allowed for these domains [%s] in %s configuration",
					implode(', ', array_values($configuration)[0]['domain']),
					$connectionName
				);
			}else{
				$errorReport = sprintf(
					"Connection not allowed for domain {%s} in {%s} configuration.",
					array_values($configuration)[0]['domain'][0],
					$connectionName
				);
			}

			throw new RuntimeException($errorReport);
		}else{
			throw new RuntimeException(sprintf(
				"Connection not allowed for domain {%s} in {%s} configuration.", array_values($configuration)[0]['domain'], $connectionName)
			);
		}
		pre($config);
		exit;
	}

	/**
	* This method throws an exception if a platform's error message is being generated
	* and the provided parameter is not the required instance.
	*
	* @param 	$instanceName <String>
	* @access 	public
	* @return 	<void>
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
	* @return 	<void>
	*/
	public function onGenerateErrorNumber(String $instanceName)
	{
		throw new InvalidArgumentException(sprintf(
			"Cannot retrieve error number. Instance of {%s} is required.", $instanceName)
		);
	}

}