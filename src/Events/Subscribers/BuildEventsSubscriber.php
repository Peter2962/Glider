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
* @author 	Peter Taiwo
* @package 	Kit\Glider\Events\Subscribers\BuildEventsSubscriber
*/

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