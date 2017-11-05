<?php
/**
* @package 	QueryBinder
* @version 	0.1.0
*
* QueryBinder saves created queries into an array that would later
* be used by the SqlGenerator to generate query.
*/

namespace Glider\Query\Builder;

use RuntimeException;
use Glider\Query\Builder\SqlGenerator;

class QueryBinder
{

	/**
	* @var 		$bindings
	* @access 	protected
	* @static
	*/
	protected 	$bindings = [
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
	public function createBinding(String $key, $queryPart, array $params=[])
	{
		if (!array_key_exists($key, $this->bindings)) {
			return false;
		}

		if ($key == 'sql') {
			return $queryPart;
		}

		$this->bindings[$key] = $queryPart;
		return $this->$key($queryPart);
	}

	/**
	* @param 	$key <String>
	* @access 	public
	* @return 	Array
	*/
	public function getBinding(String $key)
	{
		return $this->bindings[$key] ?? null;
	}

	/**
	* @param 	$parameters <Array>
	* @access 	private
	* @return 	String
	*/
	private function select(array $parameters) : String
	{
		$select = 'SELECT';
		$params = [];
		if (!empty($parameters)) {
			foreach($parameters as $param) {
				if (is_numeric($param) || is_object($param) || is_int($param)) {
					continue;
				}

				$params[] = $param;
			}
		}

		$select .= ' ' . implode(', ', $params);
		return $select;
	}

	/**
	* @param 	$parameters <Array>
	* @access 	private
	* @return 	String
	*/
	private function avg(array $parameters)
	{
		print '<pre>';
		print_r($parameters);
	}

}