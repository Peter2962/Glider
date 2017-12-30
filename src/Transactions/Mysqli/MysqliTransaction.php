<?php
namespace Kit\Glider\Transactions\Mysqli;

use Kit\Glider\Platform\Contract\PlatformProvider;
use Kit\Glider\Transactions\Contract\TransactionProvider;

class MysqliTransaction implements TransactionProvider
{

	/**
	* @var 		$provider
	* @access 	protected
	*/
	protected 	$provider;

	/**
	* {@inheritDoc}
	*/
	public function __construct(PlatformProvider $platformProvider)
	{
		$this->provider = $platformProvider;
	}

}