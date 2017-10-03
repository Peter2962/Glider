<?php
/**
* @package 	StatementProvider
* @version 	0.1.0
*
* StatementProvider helps to formulize a platform's statement. It gives
* each platform an architecture template that is required. 
*/

namespace Glider\Statement\Contract;

use Glider\Platform\Contract\PlatformProvider;

interface StatementProvider
{

	/**
	* The constructor accepts Glider\Platform\Contract\PlatformProvider as the only
	* argument.
	*
	* @param 	$platformProvider Glider\Platform\Contract\PlatformProvider
	* @access 	public
	* @return 	void
	*/
	public function __construct(PlatformProvider $platformProvider);

}