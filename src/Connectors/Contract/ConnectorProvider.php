<?php
/**
* @package 	ConnectorProvider
* @version 	0.1.0
*
* All connectors must implement this interface.
* This interface helps to configure a connector.
*/

namespace Glider\Connectors\Contract;

use Glider\Platform\Contract\PlatformProvider;

interface ConnectorProvider {

	/**
	* Constructor accepts an array type parameter which is set from the
	* platform provider. This array parameter contains the platform's connection
	* configuration.
	*
	* @param 	$config <Array>
	* @access 	public
	* @return 	void
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
	* @access 	public
	* @return 	Mixed
	*/
	public function connect(String $host=null, String $username=null, String $password=null, String $database=null, String $collation=null, String $charset=null);

	/**
	* Returns the platform's error message. The method accepts a parameter of type `object`
	* which must be the platform's connection object. E.g `mysqli`
	*
	* @param 	$connection <Object>
	* @access 	public
	* @return 	Mixed
	*/
	public function getErrorMessage($connection=null);

	/**
	* Returns the platform's generated error number. The method accepts a parameter of type `object`
	* which must be the platform's connection object. E.g `mysqli`
	*
	* @param 	$connection <Object>
	* @access 	public
	* @return 	Mixed
	*/
	public function getErrorNumber($connection=null);

}