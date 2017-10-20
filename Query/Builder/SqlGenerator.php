<?php
/**
* @package 	SqlGenerator
* @version 	0.1.0
*
* This class helps to generate sql queries from an array of query
* keywords.
*/

namespace Glider\Query\Builder;

use StdClass;
use Glider\Query\Parameters;
use Glider\Query\Builder\QueryBinder;
use Glider\Connectors\Contract\ConnectorProvider;
use Glider\Query\Exceptions\ParameterNotFoundException;
use Glider\Query\Exceptions\InvalidParameterCountException;

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

	/**
	* Converts a query string with named parameters to marked parameters and returs an object.
	*
	* @param 	$query <String>
	* @param 	$parameterBag Glider\Query\Parameters
	* @access 	public
	* @return 	Object
	*/
	public function convertToSql(String $query, Parameters $parameterBag) : StdClass
	{
		$stdClass = new StdClass();
		$stdClass->parameters = [];
		$stdClass->query = '';
		$match = false;

		if (preg_match_all('/\:([^ ]+)/s', $query, $matched)) {
			$stdClass->parameters = array_map(function($m) use ($parameterBag, $matched) {
				if ($parameterBag->getParameter($m) == null) {
					throw new InvalidParameterCountException('Number of parameters does not match length of proposed parameters.', $matched[1], $parameterBag);
				}
				return $m;
			}, $matched[1]);
		}

		$setParams = $parameterBag->getAll();
		$stdClass->query = str_replace($matched[0], '?', $query);

		return $stdClass;
	}

}