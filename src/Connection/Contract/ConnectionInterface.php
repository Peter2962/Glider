<?php
/**
* @author 		Peter Taiwo <peter@phoxphp.com>
* @package 		Kit\Glider\Connection\Contract\ConnectionInterface
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

namespace Kit\Glider\Connection\Contract;

use Closure;

interface ConnectionInterface
{

	/**
	* Attempts to make a new connection.
	*
	* @param 	$withId <String>
	* @access 	public
	* @return 	<Mixed>
	*/
	public function getAlternativeId(String $withId);

	/**
	* Returns a configured connection. Glider returns the default connection
	* if no id is provided.
	*
	* @param 	$id <String>
	* @access 	public
	* @return 	<Mixed>
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
	* @return 	<Boolean>
	* @static
	*/
	public static function has(String $id);

	/**
	* Returns the current connection status.
	*
	* @access 	public
	* @return 	<String>
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
	* @return 	<void>
	* @static
	*/
	public static function domain(String $domain, Closure $config);

	/**
	*
	* @param 	$id <String>
	* @param 	$settings <Closure>
	* @access 	public
	* @return 	<void>
	* @static
	*/
	public static function configure(String $id, Closure $settings);

}