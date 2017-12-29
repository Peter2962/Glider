<?php
namespace Kit\Glider\Events\Subscribers;

use RuntimeException;
use Kit\Glider\Events\Contract\Subscriber;

class BuildEventsSubscriber implements Subscriber
{

	/**
	* {@inheritDoc}
	*/
	public function getRegisteredEvents() : Array
	{
		return [
			'query.empty.notify' => 'onEmptyQueryInitialized'
		];
	}

	/**
	* This method throws an exception if an empty query is initialized
	* and any action that requires that the query not empty is called.
	*
	* @param 	$label <String>
	* @access 	public
	* @throws 	RuntimeException
	*/
	public function onEmptyQueryInitialized($label='')
	{
		throw new RuntimeException(sprintf('Cannot call {%s} method on an empty query.', $label));
	}

}