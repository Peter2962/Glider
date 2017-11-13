<?php
/**
* @package 	StatementProvider
* @version 	0.1.0
*
* StatementProvider helps to formulize a platform's statement. It gives
* each platform an architecture template that is required. The StatementProvider handles
* query processing. 
* @method fetch
* @method insert
* @method update
* @method delete
* @method query
*/

namespace Glider\Statements\Contract;

use Glider\Query\Parameters;
use Glider\Query\Builder\QueryBuilder;
use Glider\Query\Builder\SqlGenerator;
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

	/**
	* The fetch method is used to fetch results from the database. This method accepts instance
	* of QueryBuilder<Glider\Query\Builder\QueryBuilder> and Parameters <Glider\Query\Parameters> as an argument.
	*
	* @param 	$queryBuiler Glider\Query\Builder\QueryBuilder
	* @access 	public
	* @return 	Array
	*/
	public function fetch(QueryBuilder $queryBuiler, Parameters $parameters) : Array;

	/**
	* This method creates/saves new data. This method accepts instance
	* of QueryBuilder<Glider\Query\Builder\QueryBuilder> and
	* Parameters <Glider\Query\Parameters> as an argument.
	*
	* @access 	public
	* @return 	void
	*/
	public function insert(QueryBuilder $queryBuilder);

}