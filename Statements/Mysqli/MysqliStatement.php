<?php
namespace Glider\Statements\Mysqli;

use Glider\Platform\Contract\PlatformProvider;
use Glider\Statements\Contract\StatementProvider;
use Glider\Results\Contract\ResultObjectProvider;

class MysqliStatement implements StatementProvider
{

	/**
	* {@inheritDoc}
	*/
	public function __construct(PlatformProvider $platformProvider)
	{
		
	}

}