<?php
/**
* @package 	QueryBuilderProvider
* @version 	0.1.0
*
* Query builder provider contract that returns an architecture of Glider's
* query builder. This contract must be implemented any query builder
* that will be used.
*/

namespace Glider\Query\Builder\Contract;

use Glider\Connectors\Contract\ConnectorProvider;

interface QueryBuilderProvider
{

	/**
	* The constructor accepts an argument: Glider\Platform\Contract\ConnectorProvider
	*
	* @param 	$connectorProvider Glider\Platform\Contract\ConnectorProvider
	* @access 	public
	* @return 	void
	*/
	public function __construct(ConnectorProvider $connectorProvider);

}