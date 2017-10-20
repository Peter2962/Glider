<?php
/**
* @package 	QueryBinder
* @version 	0.1.0
*
* QueryBinder saves created queries into an array that would later
* be used by the SqlGenerator to generate query.
*/

namespace Glider\Query\Builder;

use Glider\Query\Builder\SqlGenerator;

class QueryBinder
{

	/**
	* @var 		$bindings
	* @access 	protected
	* @static
	*/
	protected 	$bindings = [];

	/**
	* @var 		$generator
	* @access 	protected
	*/
	protected 	$generator;

	/**
	* @access 	public
	* @return 	void
	*/
	public function __construct()
	{
		$this->bindings = [
			'sql' => '',
			'select' => [],
			'join' => [],
			'innerjoin' => [],
			'outerjoin' => [],
			'rightOuterJoin' => [],
			'fulljoin' => [],
			'where' => [
				'parameters' => []
			],
			'insert' => [
				'parameters' => []
			],
			'update' => [],
			'delete' => []
		];

		$this->generator = new SqlGenerator($this);
	}

	/**
	* This method bindings together queries created with
	* the query builder.
	*
	* @param 	$key <String>
	* @param 	$queryPart <Mixed>
	* @param 	$params <Array>
	* @access 	public
	* @return 	Mixed
	*/
	public function createBinding(String $key, $queryPart, array $params=array())
	{
		if (!array_key_exists($key, $this->bindings)) {
			return false;
		}

		switch ($key) {
			case 'sql':
				// $key is raw sql, return query string.
				return $queryPart;
				break;
			
			default:
				return $queryPart;
				break;
		}
		
		$this->bindings[$key] = $queryPart;
	}

	/**
	* Returns array of created queries.
	*
	* @access 	public
	* @return 	Array
	*/
	public function getBinding() : Array
	{
		return $this->bindings;
	}

}