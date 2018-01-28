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