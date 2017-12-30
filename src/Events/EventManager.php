<?php
/**
* @package 	EventManager
* @version 	0.1.0
* This class helps to make and fire events at some certain sections of Glider.
* Note that this is just a simple event architecture class for Glider.
*/

namespace Kit\Glider\Events;

use Closure;
use Kit\Glider\ClassLoader;
use Kit\Glider\Events\Contract\Subscriber;

class EventManager
{

	/**
	* @var 		$listenerId
	* @access 	protected
	*/
	protected 	$listenerId;

	/**
	* @var 		$listeners
	* @access 	private
	*/
	private static $listeners = [];

	/**
	* const 	APPEND_LISTENER
	*/
	const 		APPEND_LISTENER = 124;

	/**
	* The constructor accepts two parameters which are optional. The first parameter
	* is the listenerId that will be used to target the initial event and the second
	* parameter `callback` is the callback that will be triggered when the event is being
	* triggered.
	*
	* @param 	$listenerId <String>
	* @param 	$callback <Mixed>
	* @access 	public
	* @return 	void
	*/
	public function __construct(String $listenerId=null, $callback=null)
	{
		$this->listenerId = $listenerId;
	}

	/**
	* Creates a new listener. Two parameters are required. The eventId that will be used
	* to track the current event and the callback which can be either an array or a closure.
	*
	* @param 	$eventId <String>
	* @param 	$callback <Mixed>
	* @access 	public
	* @static
	* @return 	void
	*/
	public static function listenTo(String $eventId, $callback)
	{
		if (!in_array(gettype($callback), ['array', 'object', 'closure'])) {
			return false;
		}

		EventManager::$listeners[$eventId][] = $callback;
	}

	/**
	* Dispatches an event with the @param $eventId only if it exists.
	*
	* @param 	$eventId <String>
	* @param 	$subscriber Kit\Glider\Events\Contract\Subscriber
	* @access 	public
	* @return 	void
	*/
	public function dispatchEvent(String $eventId, $subscriber=null)
	{
		if (isset(EventManager::$listeners[$eventId])) {
			foreach(EventManager::$listeners[$eventId] as $listener) {
				call_user_func_array($listener, [$subscriber]);
			}
		}
	}

	/**
	* This method attaches an event through it's subscribe object. List of events
	* are loaded from the subscriber and added to the listeners.
	*
	* @param 	$subscriber Kit\Glider\Events\Contract\Subcriber
	* @access 	public
	* @return 	void
	*/
	public function attachSubscriber(Subscriber $subscriber)
	{
		$listeners = $subscriber->getRegisteredEvents();
		foreach($listeners as $id => $listener) {
			EventManager::listenTo($id, array($subscriber, $listener));
		}
	}

}