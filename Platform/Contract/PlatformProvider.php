<?php
/**
* @package 	PlatformProvider
* @version 	0.1.0
*
* Platform provider interface for all available platforms
* registered. All platform providers must implement this interface.
*/

namespace Glider\Platform\Contract;

use Glider\Events\EventManager;
use Glider\Connection\PlatformResolver;
use Glider\Connectors\Contract\ConnectorProvider;

interface PlatformProvider
{

	/**
	* The constructor accepts two arguments: Glider\Connection\PlatformResolver which
	* passes the configuration to it and Glider\Events\EventManager which handles the
	* platform events.
	*
	* @param 	$platform Glider\Connection\PlatformResolver
	* @param 	$eventManager Glider\Events\EventManager	
	* @access 	public
	* @return 	void
	*/
	public function __construct(PlatformResolver $platformResolver, EventManager $eventManager);

	/**
	* The platform's connector provider that will be used to initialize
	* a connection with the database.
	*
	* @access 	public
	* @return 	Object Glider\Connectors\Contract\ConnectorProvider
	*/
	public function connector() : ConnectorProvider;

	/**
	* Returns a configuraiton key if it exists. Returns null if it does not.
	*
	* @param 	$key <String>
	* @access 	public
	* @return 	Mixed
	*/
	public function getConfig(String $key=null);

}