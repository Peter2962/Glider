<?php
/**
* @package 	SqlGenerator
* @version 	0.1.0
*
* This class helps to generate sql queries from an array of query
* keywords.
*/

namespace Glider\Query\Builder;

use Glider\Query\Builder\QueryBinder;
use Glider\Connectors\Contract\ConnectorProvider;

class SqlGenerator
{

	/**
	* Set of keys that are not allowed when running a select query.
	*
	* @var 		$disallowedChars
	* @access 	private
	*/
	private 	$disallowedChars = ['?', '&', '%', '$', '#', '+', '!', ')', '(', '-', '^', '_', '=', '/', '>', '<', ':', ';'];

	/**
	* Constructor accepts Glider\Query\Builder\QueryBinder as an argument. It gets the
	* created queries and then generates sql query from it.
	*
	* @param 	$binder Glider\Query\Builder\QueryBinder
	* @access 	public
	* @return 	void
	*/
	public function __construct(QueryBinder $binder)
	{

	}

	public function convertToSql()
	{

	}

}