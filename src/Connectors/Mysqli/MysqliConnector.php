<?php
/**
* MIT License
* Permission is hereby granted, free of charge, to any person obtaining a copy
* of this software and associated documentation files (the "Software"), to deal
* in the Software without restriction, including without limitation the rights
* to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
* copies of the Software, and to permit persons to whom the Software is
* furnished to do so, subject to the following conditions:

* The above copyright notice and this permission notice shall be included in all
* copies or substantial portions of the Software.

* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
* IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
* FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
* AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
* LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
* OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
* SOFTWARE.
*/

##################################
# Mysqli database connection class 
##################################

namespace Kit\Glider\Connectors\Mysqli;

use mysqli;
use StdClass;
use Kit\Glider\Events\EventManager;
use Kit\Glider\Events\Contract\Subscriber;
use Kit\Glider\Platform\Contract\PlatformProvider;
use Kit\Glider\Connectors\Contract\ConnectorProvider;
use Kit\Glider\Events\Subscribers\ConnectionAttemptSubscriber;

class MysqliConnector implements ConnectorProvider
{

	/**
	* @var 		$platformProvider
	* @access 	private
	*/
	private 	$platformProvider;

	/**
	* @var 		$connection
	* @access 	private
	*/
	private 	$connection;

	/**
	* @var 		$hasError
	* @access 	private
	*/
	public static $hasError = false;

	/**
	* {@inheritDoc}
	*/
	public function __construct(PlatformProvider $platformProvider)
	{
		$this->platformProvider = $platformProvider;
	}

	/**
	* {@inheritDoc}
	*/
	public function connect(String $host=null, String $username=null, String $password=null, String $database=null, String $collation=null, String $charset=null, String $driver=null, Array $options=[], int $port=0000)
	{
		$connection = new StdClass;
		$host = $host == null ? $this->platformProvider->getConfig('host') : $host;
		$username = $username == null ? $this->platformProvider->getConfig('username') : $username;
		$password = $password == null ? $this->platformProvider->getConfig('password') : $password;
		$database = $database == null ? $this->platformProvider->getConfig('database') : $database;
		$collation = $collation == null ? $this->platformProvider->getConfig('collation') : $collation;
		$charset = $charset == null ? $this->platformProvider->getConfig('charset') : $charset;

		$connection = new mysqli($host, $username, $password, $database);

		// If there is an error establishing a connection, attach the `ConnectionAttemptSubscriber` to
		// the event manager to dispatch.
		if ($connection->connect_error) {
			// If an error occurred while establishin a connection, we'll dispatch the connect.failed
			// event that will send the necessary error message.
			$this->platformProvider->eventManager->dispatchEvent('connect.failed', $connection->connect_error);
		}

		// If `collation` is set in the configuration or we are able to get it from
		// the platform provider, we will make an attempt to set the collation to the
		// configuration value.
		if ($this->platformProvider->getConfig('collation')) {
			$this->setCollation($connection, $collation);
		}

		// If `charset` is set in the configuration just like the `collation`,
		// we will make an attempt to set it as well.
		if ($this->platformProvider->getConfig('charset')) {
			$this->setCharset($connection, $charset);
		}

		$this->connection = $connection;
		return $this->connection;
	}

	/**
	* {@inheritDoc}
	*/
	public function getErrorMessage($connection=null)
	{
		if (!$connection instanceof mysqli) {
			$this->platformProvider->eventManager->dispatchEvent('connect.failed.message.instance', 'mysqli');
		}
		return $connection->error;
	}

	/**
	* {@inheritDoc}
	*/
	public function getErrorNumber($connection=null)
	{
		if (!$connection instanceof mysqli) {
			$this->platformProvider->eventManager->dispatchEvent('connect.failed.number.instance', 'mysqli');
		}
		return $connection->errno;
	}

	/**
	* Sets the collation for the initialized connection.
	*
	* @param 	$connection mysqli
	* @param 	$collation <String>
	* @access 	protected
	* @return 	void
	*/
	protected function setCollation(mysqli $connection, String $collation)
	{
		//
	}

	/**
	* Sets the charset to be used by default by the database server.
	*
	* @param 	$connection mysqli
	* @param 	$charset <String>
	* @access 	protected
	* @return 	void
	*/
	protected function setCharset(mysqli $connection, String $charset)
	{
		$connection->set_charset($charset);
	}

}