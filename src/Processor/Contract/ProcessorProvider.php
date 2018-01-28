<?php
/**
* @package 	ProcessorProvider
* @version 	0.1.0
*
* ProcessorProvider gives each platform an architecture template that is required.
* @method fetch
* @method insert
* @method update
* @method delete
* @method query
* @method getResult
*/

namespace Kit\Glider\Processor\Contract;

use Kit\Glider\Query\Parameters;
use Kit\Glider\Result\Collection;
use Kit\Glider\Query\Builder\QueryBuilder;
use Kit\Glider\Query\Builder\SqlGenerator;
use Kit\Glider\Platform\Contract\PlatformProvider;

interface ProcessorProvider
{

	/**
	* The constructor accepts Kit\Glider\Platform\Contract\PlatformProvider as the only
	* argument.
	*
	* @param 	$platformProvider Kit\Glider\Platform\Contract\PlatformProvider
	* @access 	public
	* @return 	void
	*/
	public function __construct(PlatformProvider $platformProvider);

	/**
	* The fetch method is used to fetch results from the database. This method accepts instance
	* of QueryBuilder<Kit\Glider\Query\Builder\QueryBuilder> and Parameters <Kit\Glider\Query\Parameters> as an argument.
	*
	* @param 	$queryBuiler Kit\Glider\Query\Builder\QueryBuilder
	* @access 	public
	* @return 	Kit\Glider\Result\Collection
	*/
	public function fetch(QueryBuilder $queryBuiler, Parameters $parameters) : Collection;

	/**
	* This method creates/saves new data. This method accepts instance
	* of QueryBuilder<Kit\Glider\Query\Builder\QueryBuilder> and
	* Parameters <Kit\Glider\Query\Parameters> as an argument.
	*
	* @access 	public
	* @return 	void
	*/
	public function insert(QueryBuilder $queryBuilder, Parameters $parameters);

	/**
	* Update data in the database. This method accepts instance
	* of QueryBuilder<Kit\Glider\Query\Builder\QueryBuilder> and
	* Parameters <Kit\Glider\Query\Parameters> as an argument.
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
	* To be able to use this, make sure Kit\Glider\Platform\Contract\PlatformProvider::isQueryCompatible
	* returns true.
	* The first parameter is the query string and second parameter is the mysqli return type.
	* The second parameter accepts either 1 or 2. If the value is set to 1, it will return an instance
	* of mysqli_result and if it is set to 2, it will return an instance of mysqli_stmt.
	*
	* @param 	$queryString <String>
	* @access 	public
	* @return 	Mixed 
	*/
	public function query(String $queryString, int $returnType=1);

}