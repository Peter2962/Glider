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
* @package 	Kit\Glider\Schema\Contract\SchemaManagerContract
*/

namespace Kit\Glider\Schema\Contract;

use Closure;
use Kit\Glider\Schema\Column;
use Kit\Glider\Query\Builder\QueryBuilder;
use Kit\Glider\Connection\ConnectionManager;

interface SchemaManagerContract
{

	/**
	* Constructor accepts an optional parameter which is the connection id.
	*
	* @param 	$connectionId <String>
	* @param 	$queryBuilder <Kit\Glider\Query\Builder\QueryBuilder>
	* @access 	public
	* @return 	void
	*/
	public function __construct(String $connectionId=null, QueryBuilder $queryBuilder);

	/**
	* Call SchemaManager methods statically.
	*
	* @param 	$method <String>
	* @param 	$parameters <Array>
	* @access 	public
	* @return 	Mixed
	*/
	public static function __callStatic($method, $parameters);

	/**
	* Create database.
	*
	* @param 	$databaseName <String>
	* @access 	public
	* @return 	Mixed
	*/
	public function createDatabase(String $databaseName);

	/**
	* Creates database if it does not exist.
	*
	* @param 	$databaseName <String>
	* @access 	public
	* @return 	Mixed
	*/
	public function createDatabaseIfNotExist(String $databaseName);

	/**
	* Switch database using the USE statement.
	*
	* @param 	$databaseName <String>
	* @access 	public
	* @return 	Mixed
	*/
	public function switchDatabase(String $databaseName);

	/**
	* Drops a database.
	*
	* @param 	$databaseName <String>
	* @access 	public
	* @return 	Mixed
	*/
	public function dropDatabase(String $databaseName);

	/**
	* Check if database has a table.
	*
	* @param 	$table <String>
	* @access 	public
	* @return 	Boolean
	*/
	public function hasTable(String $table) : Bool;

	/**
	* Returns array of tables in the database.
	*
	* @access 	public
	* @return 	Array
	*/
	public function getAllTables();

	/**
	* Checks if a table has a column.
	*
	* @param 	$table <String>
	* @param 	$column <String>
	* @access 	public
	* @return 	Boolean
	*/
	public function hasColumn(String $table, String $column) : Bool;

	/**
	* Returns an array of a table's columns.
	*
	* @param 	$table <String>
	* @access 	public
	* @return 	Mixed
	*/
	public function getColumns(String $table);

	/**
	* Return array of columns names in a table.
	*
	* @param 	$table <String>
	* @access 	public
	* @return 	Mixed
	*/
	public function getColumnNames(String $table);

	/**
	* Return an array of column types.
	*
	* @param 	$table <String>
	* @access 	public
	* @return 	Mixed
	*/
	public function getColumnTypes(String $table);

	/**
	* Returns a column in a table.
	*
	* @param 	$table <String>
	* @param 	$column <String>
	* @access 	public
	* @return 	Mixed
	*/
	public function getColumn(String $table, String $column) : Column;

	/**
	* Returns a column type in a table.
	*
	* @param 	$table <String>
	* @param 	$column <String>
	* @access 	public
	* @return 	Mixed
	*/
	public function getColumnType(String $table, String $column);

	/**
	* Return an instance of table.
	*
	* @param 	$tableName <String>
	* @param 	$column <Closure>
	* @access 	public
	* @return 	void
	*/

	/**
	* Sets table storage engine.
	*
	* @param 	$engine <String>
	* @access 	public
	* @return 	Mixed
	*/
	public function setTableEngine(String $engine);

	/**
	* Checks if a table has a foreign key.
	*
	* @param 	$table <String>
	* @param 	$foreignKey <String>
	* @access 	public
	* @return 	Boolean
	*/
	public function hasForeign(String $table, String $foreignKey) : Bool;

	/**
	* Drops a foreign key.
	*
	* @param 	$table <String>
	* @param 	$foreignKey <String>
	* @access 	public
	* @return 	Boolean
	*/
	public function dropForeign(String $table, String $foreignKey) : Bool;

}