<?php
/**
* @author 		Peter Taiwo <peter@phoxphp.com>
* @package 		Kit\Glider\Transactions\Contract\TransactionProvider
* @license 		MIT License
*
* Permission is hereby granted, free of charge, to any person obtaining a copy
* of this software and associated documentation files (the "Software"), to deal
* in the Software without restriction, including without limitation the rights
* to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
* copies of the Software, and to permit persons to whom the Software is
* furnished to do so, subject to the following conditions:
*
* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
* IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
* FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
* AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
* LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
* OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
* SOFTWARE.
* -----------------------------------------------------------------------------
* Transaction provider constructs the methods that platforms transaction
* provider will imitate. This helps to have more control on how to initialize
* each platform's transaction methods.
*/

namespace Kit\Glider\Transactions\Contract;

use Kit\Glider\Platform\Contract\PlatformProvider;

interface TransactionProvider
{

	/**
	* Constructor accepts `PlatformProvider` contract as an argument.
	*
	* @param 	$platformProvider <Kit\Glider\Platform\Contract\PlatformProvider>
	* @access 	public
	* @return 	<void>
	*/
	public function __construct(PlatformProvider $platformProvider);

	/**
	* Begins a transaction. This method accepts an argument which is the current
	* connection that is being used.
	*
	* @param 	$connection <Mixed>
	* @access 	public
	* @return 	<Mixed>
	*/
	public function begin($connection);

	/**
	* Commits a transaction.
	*
	* @param 	$connection <Object>
	* @access 	public
	* @return 	<Mixed>
	*/
	public function commit($connection);

	/**
	* Rolls back a transaction.
	*
	* @param 	$connection <Object>
	* @access 	public
	* @return 	<Mixed>
	*/
	public function rollback($connection);
	
}