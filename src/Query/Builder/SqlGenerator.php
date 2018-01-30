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
* @package 	SqlGenerator
* @version 	0.1.0
*
* This class helps to generate sql queries from an array of query
* keywords.
*/

namespace Kit\Glider\Query\Builder;

use StdClass;
use Kit\Glider\Query\Parameters;
use Kit\Glider\Query\Builder\Type;
use Kit\Glider\Query\Builder\QueryBinder;
use Kit\Glider\Connectors\Contract\ConnectorProvider;
use Kit\Glider\Query\Exceptions\ParameterNotFoundException;
use Kit\Glider\Query\Exceptions\InvalidParameterCountException;

class SqlGenerator
{

	/**
	* Set of keys that are not allowed when in a select query.
	*
	* @var 		$disallowedChars
	* @access 	private
	*/
	private 	$disallowedChars = ['?', '&', '%', '$', '#', '+', '!', ')', '(', '-', '^', '=', '/', '>', '<', ':', ';'];

	/**
	* Constructor accepts Kit\Glider\Query\Builder\QueryBinder as an argument. It gets the
	* created queries and then generates sql query from it.
	*
	* @access 	public
	* @return 	void
	*/
	public function __construct()
	{
		//
	}

	/**
	* Converts a query string with named parameters to marked placeholders and returs an object.
	*
	* @param 	$query <String>
	* @param 	$parameterRepository <Kit\Glider\Query\Parameters>
	* @access 	public
	* @return 	Object
	*/
	public function convertToSql(String $query, Parameters $parameterRepository) : StdClass
	{
		$stdClass = new StdClass();
		$stdClass->parameterValues = [];
		$placeholder = '?';
		$stdClass->query = '';
		$match = false;

		if (preg_match_all('/\:([^ ,]+)/s', $query, $matched)) {
			$stdClass->parameterValues = array_map(function($value) use ($parameterRepository, $matched) {
				$value = str_replace(',', '', $value);
				if ($parameterRepository->getParameter($value) == null) {
					throw new InvalidParameterCountException(
						'Number of parameters does not match length of proposed parameters.',
						$matched[1],
						$parameterRepository
					);
				}

				return $parameterRepository->getParameter($value);
			}, $matched[1]);
		}

		$stdClass->query = str_replace($matched[0], '?', $query);

		if (sizeof($stdClass->parameterValues) < 1) {
			$stdClass->parameterValues = array_values($parameterRepository->getAll());
		}

		return $stdClass;
	}

	/**
	* Returns an array of selected fields in a `SELECT` statement.
	*
	* @param 	$query <String>
	* @access 	public
	* @return 	Array
	*/
	public function getSelectedFields(String $query) : Array
	{
		$columns = [];

		if (Type::getStatementType($query) == 1) {
			if (preg_match("/(SELECT|select|Select)(.*?)FROM|from|From([^ ]+)/s", $query, $matches)) {
				$columns = explode(',', $matches[2]);
				$columns = array_map(function($field) {
					return trim(ltrim($field));
				}, $columns);
			}
		}

		return $columns;
	}

	/**
	* This method returns an array of fields to map in a query.
	*
	* @param 	$query <String>
	* @access 	public
	* @return 	Array
	*/
	public function hasMappableFields(String $query) : Array
	{
		$fields = [];

		if (preg_match("/=([^ ]+)?/s", $query, $matches)) {
			$fields = $matches;
		}

		return $fields;
	}

	/**
	* Return array of disallowed characters.
	*
	* @access 	public
	* @return 	Array
	*/
	public function getDisallowedChars() : Array
	{
		return $this->disallowedChars;
	}

}