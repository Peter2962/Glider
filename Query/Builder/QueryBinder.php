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
		'where' => [],
		'insert' => [
			'parameters' => []
		],
		'update' => [],
		'delete' => [],
		'between' => [],
		'like' => []
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
	* @param 	$params <Mixed>
	* @param 	$expr 	<Mixed>
	* @param 	$with 	<Mixed>
	* @access 	public
	* @return 	Mixed
	*/
	public function createBinding(String $key, $queryPart, $params=[], $expr='', $with='', $addValue=true)
	{
		if (!array_key_exists($key, $this->bindings)) {
			return false;
		}

		if ($key == 'sql') {
			return $queryPart;
		}

		if ($addValue == true) {
			$this->bindings[$key] = $queryPart;
		}

		return $this->$key($queryPart, $params, $expr, $with, $addValue);
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
	* Create and return alias for a column.
	*
	* @param 	$column <String>
	* @param 	$alias <String>
	* @access 	public
	* @return 	String
	*/
	public function alias(String $column, String $alias)
	{
		// if (!$this->getBinding('select') || empty($this->getBinding('select'))) {
			// Since this method cannot be used without the SELECT statement,
			// we will throw an exception if `SELECT` binding is null or false. 
			// throw new RuntimeException(sprintf('Cannot call aggregate function on empty select.'));
		// }
		$alias = str_replace($this->generator->getDisallowedChars(), '', $alias);
		return $this->attachSeparator($column . ' AS ' . $alias);
	}

	/**
	* @param 	$parts <String>
	* @access 	private
	* @return 	String
	*/
	private function attachSeparator(String $parts)
	{
		$separator = ', ';
		if (!$this->getBinding('select') || empty($this->getBinding('select'))) {
			$separator = 'SELECT ';
			$this->binding['select'][] = $parts; 
		}

		return $separator . $parts;
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
	* @param 	$column <String>
	* @param 	$value <Mixed>
	* @param 	$with <Mixed>
	* @param 	$operator <String>
	* @access 	private
	* @return 	String
	*/
	private function where(String $column, $value='', String $with='=', String $operator='AND') : String
	{
		$where = '';

		// We'll be doing a check to see if `WHERE` clause already exists in the query. 
		if (empty($this->bindings['where'])) {
			$where = ' WHERE ' . $column;
		}else{
			$where = ' '. $operator .' ' . $column;
		}

		if (!empty($value)) {
			$where .= ' ' . $with . ' ?';
		}else if ($value == NULL) {
			$where .= ($with == '=') ? ' IS NULL' : ' IS NOT NULL';
		}

		$this->bindings['where'][] = $where;
		return $where;
	}

	/**
	* @param 	$colum <String>
	* @param 	$leftValue <Mixed>
	* @param 	$rightValue <Mixed>
	* @param 	$operator <String>
	* @param 	$isNOt <Boolean>
	* @access 	private
	* @return 	String
	*/
	private function between(String $column, $leftValue, $rightValue, String $operator='AND', Bool $isNOt=true) : String
	{
		$with = ($isNOt == true) ? 'BETWEEN' : 'NOT BETWEEN';
		$parts = ' WHERE ' . $column . ' ' . $with . ' ' . $leftValue . ' ' . $operator . '  ' . $rightValue;
		$this->bindings['where'][] = $parts;
		return $parts;
	}

	/**
	* @param 	$column <String>
	* @param 	$pattern <String>
	* @param 	$notLike <Boolean>
	* @access 	private
	* @return 	String
	*/
	private function like(String $column, String $pattern, String $operator='AND', Bool $notLike=false) : String
	{
		$with = ($notLike == true) ? ' LIKE ' : ' NOT LIKE ';
		$parts = $column . $with . '\'' . $pattern . '\'';

		if (!empty($this->getBinding('where'))) {
			$parts = ' ' . $operator . ' ' . $parts;
		}else{
			$parts = ' WHERE ' . $parts;
		}

		$this->bindings['where'][] = $parts;
		return $parts;
	}

}