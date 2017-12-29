<?php
/**
* This interface must be implemented by all subscribers that will be
* attached to the event manager.
*/

namespace Kit\Glider\Events\Contract;

interface Subscriber
{

	/**
	* This method returns an array of events subscribed to.
	*
	* @access 	public
	* @return 	Array
	*/
	public function getRegisteredEvents() : Array;

}