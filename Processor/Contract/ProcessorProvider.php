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

namespace Glider\Processor\Contract;

use Glider\Query\Parameters;
use Glider\Result\Collection;
use Glider\Query\Builder\QueryBuilder;
use Glider\Query\Builder\SqlGenerator;
use Glider\Platform\Contract\PlatformProvider;

interface ProcessorProvider
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
	* @return 	Glider\Result\Collection
	*/
	public function fetch(QueryBuilder $queryBuiler, Parameters $parameters) : Collection;

	/**
	* This method creates/saves new data. This method accepts instance
	* of QueryBuilder<Glider\Query\Builder\QueryBuilder> and
	* Parameters <Glider\Query\Parameters> as an argument.
	*
	* @access 	public
	* @return 	void
	*/
	public function insert(QueryBuilder $queryBuilder, Parameters $parameters);

	/**
	* Update data in the database. This method accepts instance
	* of QueryBuilder<Glider\Query\Builder\QueryBuilder> and
	* Parameters <Glider\Query\Parameters> as an argument.
	*
	* @access 	public
	* @return 	void
	*/
	public function update(QueryBuilder $queryBuilder, Parameters $parameters);

	/**
	* Returns the statement result.
	*
	* @access 	public
	* @return 	void
	*/
	public function getResult();

	/**
	* Runs a custom query using the platform's query method.
	* To be able to use this, make sure Glider\Platform\Contract\PlatformProvider::isQueryCompatible
	* returns true.
	*
	* @param 	$queryString <String>
	* @access 	public
	* @return 	Mixed 
	*/
	public function query(String $queryString);

}