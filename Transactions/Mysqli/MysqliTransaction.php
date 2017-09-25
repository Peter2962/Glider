<?php
namespace Glider\Transactions\Mysqli;

use Glider\Platform\Contract\PlatformProvider;
use Glider\Transactions\Contract\TransactionProvider;

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