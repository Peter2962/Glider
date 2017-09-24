<?php
namespace Glider\Connectors\Contract;

/**
* All connectors must implement this interface.
* This interface helps to configure a connector.
*/

interface ConnectorProvider {

	/**
	* Connects a database connect to the server.
	*
	* @param 	$host <String>
	* @param 	$username <String>
	* @param 	$password <String>
	*/
	public function connect(String $host, String $username, String $password);

}