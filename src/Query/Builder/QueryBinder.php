<?php
/**
* MIT License
* Permission is hereby granted, free of charge, to any person obtaining a copy
* of this software and associated documentation files (the "Software"), to deal
* in the Software without restriction, including without limitation the rights
* to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
* copies of the Software, and to permit persons to whom the Software is
* furnished to do so, subject to the following conditions:

* The above copyright notice and this permission notice shall be included in all
* copies or substantial portions of the Software.

* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
* IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
* FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
* AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
* LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
* OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
* SOFTWARE.
*/

/**
* @author 	Peter Taiwo
* @package 	Kit\Glider\Query\Builder\QueryBinder
*
* QueryBinder saves created queries into an array that would later
* be used by the SqlGenerator to generate query.
*/

namespace Kit\Glider\Query\Builder;

use RuntimeException;
use Kit\Glider\Query\Builder\SqlGenerator;
use Kit\Glider\Query\Builder\QueryBuilder;

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
	* @var 		$queryBuilder
	* @access 	protected
	*/
	protected 	$queryBuilder;

	/**
	* @param 	$queryBuilder <Kit\Glider\Query\Builder\QueryBuilder>
	* @access 	public
	* @return 	void
	*/
	public function __construct(QueryBuilder $queryBuilder)
	{
		$this->generator = new SqlGenerator($this);
		$this->queryBuilder = $queryBuilder;
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
			$where .= ' ' . $with . ' :' . $column;
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

	/**
	* @param 	$table <String>
	* @param 	$fields <Array>
	* @access 	private
	* @return 	String
	*/
	private function insert(String $table, Array $fields)
	{
		$placeholders = implode(', ', array_fill(0, count(array_keys($fields)), '?'));
		$columns = implode(', ', array_keys($fields));

		return "INSERT INTO $table ($columns) VALUES ($placeholders)";
	}

	/**
	* @param 	$table <String>
	* @param 	$columns <Array>
	* @param 	$conditions <Array>
	* @access 	private
	* @return 	String
	*/
	private function update(String $table, Array $columns)
	{
		$platformName = $this->queryBuilder->getPlatformName();

		$placeholders = implode(', ', array_fill(0, count(array_keys($columns)), '?'));
		$query = "UPDATE $table";
		$clause = [];
		$parameters = [];
		$set = null;

		if (empty($columns)) {
			throw new RuntimeException('Update query failed. Columns cannot be empty');
		}

		foreach(array_keys($columns) as $key) {
			$clause[] = $key = $key . ' = :' . $key;
		}

		if (sizeof($clause) > 0) {
			$set = implode(', ', $clause);
			$query .= ' SET ' . $set;
		}

		if (!empty($this->bindings['where'])) {
			$conditions = implode(' ', $this->bindings['where']);
			$query .= '' . $conditions;
		}

		return $query;
	}

	/**
	* @param 	$table <String>
	* @access 	private
	* @return 	String
	*/	
	private function delete(String $table)
	{
		$query = 'DELETE FROM ' . $table;

		if (!empty($this->bindings['where'])) {
			$conditions = implode(' ', $this->bindings['where']);
			$query .= '' . $conditions;
		}

		return $query;
	}

}