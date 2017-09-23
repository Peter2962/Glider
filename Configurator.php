<?php
namespace Glider;

use Closure;
use Glider\Connection\QueuedConnections;
use Glider\Contract\ConfiguratorInterface;

class Configurator implements ConfiguratorInterface
{

	/**
	* @var 		$key
	* @access 	private
	*/
	private 	$key;

	/**
	* @param 	$key <String>
	* @access 	public
	* @return 	void
	*/
	public function __construct(String $key)
	{
		$this->key = $key;
	}

	/**
	* Helps to attach a new configuration to the configurator.
	*
	* @param 	$connections Glider\Connection\QueuedConnections
	* @param 	$settings <Closure>
	* @access 	public
	* @return 	void
	*/
	public function attachConfiguration(QueuedConnections $conenctions, $settings)
	{
		if (!$this->key) {
			return;
		}

		var_dump($settings);
	}

}