<?php
/**
* @package 	TransactionProvider
* @version 	0.1.0
*
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
	* @param 	$platformProvider Kit\Glider\Platform\Contract\PlatformProvider
	* @access 	public
	* @return 	void
	*/
	public function __construct(PlatformProvider $platformProvider);
	
}