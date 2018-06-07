<?php
/**
* @author 		Peter Taiwo <peter@phoxphp.com>
* @package 		Kit\Glider\Connectors\Contract\ConnectorProvider
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

namespace Kit\Glider\Connectors\Contract;

use Kit\Glider\Platform\Contract\PlatformProvider;

interface ConnectorProvider {

	/**
	* Constructor accepts an array type parameter which is set from the
	* platform provider. This array parameter contains the platform's connection
	* configuration.
	*
	* @param 	$config <Array>
	* @access 	public
	* @return 	<void>
	*/
	public function __construct(PlatformProvider $platformProvider);

	/**
	* Initializes a database connection with the server.
	*
	* @param 	$host <String>
	* @param 	$username <String>
	* @param 	$password <String>
	* @param 	$database <String>
	* @param 	$collation <String>
	* @param 	$charset <String>
	* @param 	$driver <String>
	* @param 	$options <Array>
	* @param 	$port <Integer>
	* @access 	public
	* @return 	<Mixed>
	*/
	public function connect(
		String $host=null,
		String $username=null,
		String $password=null,
		String $database=null,
		String $collation=null,
		String $charset=null,
		String $driver=null,
		Array $options=[],
		int $port=0000
	);

	/**
	* Returns the platform's error message. The method accepts a parameter of type `object`
	* which must be the platform's connection object. E.g `mysqli`
	*
	* @param 	$connection <Object>
	* @access 	public
	* @return 	<Mixed>
	*/
	public function getErrorMessage($connection=null);

	/**
	* Returns the platform's generated error number. The method accepts a parameter of type `object`
	* which must be the platform's connection object. E.g `mysqli`
	*
	* @param 	$connection <Object>
	* @access 	public
	* @return 	<Mixed>
	*/
	public function getErrorNumber($connection=null);

}