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
* @package 	Kit\Glider\Processor\Contract\ProcessorProvider
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
use Kit\Glider\Statements\Contract\StatementContract;

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
	* @return 	Kit\Glider\Statements\Contract\StatementContract
	*/
	public function insert(QueryBuilder $queryBuilder, Parameters $parameters) : StatementContract;

	/**
	* Update data in the database. This method accepts instance
	* of QueryBuilder<Kit\Glider\Query\Builder\QueryBuilder> and
	* Parameters <Kit\Glider\Query\Parameters> as it's arguments.
	*
	* @param 	$queryBuilder <Kit\Glider\Query\Builder\QueryBuilder>
	* @param 	$parameters <Kit\Glider\Query\Parameters>
	* @access 	public
	* @return 	Object Kit\Glider\Statements\Contract\StatementContract
	*/
	public function update(QueryBuilder $queryBuilder, Parameters $parameters) : StatementContract;

	/**
	* Deletes record/data in the database. This method accepts instance
	* of QueryBuilder<Kit\Glider\Query\Builder\QueryBuilder> and
	* Parameters <Kit\Glider\Query\Parameters> as it's arguments.
	*
	* @param 	$queryBuilder <Kit\Glider\Query\Builder\QueryBuilder>
	* @param 	$parameters <Kit\Glider\Query\Parameters>
	* @access 	public
	* @return 	Object Kit\Glider\Statements\Contract\StatementContract
	*/
	public function delete(QueryBuilder $queryBuilder, Parameters $parameters) : StatementContract;

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
	* @param 	$returnType <Integer>
	* @access 	public
	* @return 	Mixed 
	*/
	public function query(String $queryString, int $returnType=1);

}