<?php
/**
* MIT License
* Permission is hereby granted, free of charge, to any person obtaining a copy
* of this software and associated documentation files (the "Software"), to deal
* in the Software without restriction, including without limitation the rights
* to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
* copies of the Software, and to permit persons to whom the Software is
* furnished to do so, subject to the following conditions:

* The above copyright notice and this permission notice shall be included in all
* copies or substantial portions of the Software.

* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
* IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
* FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
* AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
* LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
* OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
* SOFTWARE.
*/

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