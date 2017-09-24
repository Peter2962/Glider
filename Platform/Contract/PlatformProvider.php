<?php
namespace Glider\Platform\Contract;

use Glider\Connectors\Contract\ConnectorProvider;

/**
* @package 	PlatformProvider
* @version 	0.1.0
* Platform provider interface for all available platforms
* registered. All platform providers must implement this interface.
*/

interface PlatformProvider
{

	/**
	* The platform's connector provider that will be used to initialize
	* a connection with the database.
	*
	* @access 	public
	* @return 	Object Glider\Connectors\Contract\ConnectorProvider
	*/
	public function connector() : ConnectorProvider;

}