<?php
/**
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
	* Connects a database connect to the server.
	*
	* @param 	$host <String>
	* @param 	$username <String>
	* @param 	$password <String>
	* @param 	$database <String>
	* @access 	public
	*/
	public function connect(String $host=null, String $username=null, String $password=null, String $database=null);

}