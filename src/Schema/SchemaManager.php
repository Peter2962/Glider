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
* @package 	Kit\Glider\Schema\SchemaManager
*/

namespace Kit\Glider\Schema;

use Closure;
use Kit\Glider\Schema\Table;
use Kit\Glider\Schema\Column;
use Kit\Glider\Schema\Expressions;
use Kit\Glider\Query\Builder\QueryBuilder;
use Kit\Glider\Connection\ConnectionManager;
use Kit\Glider\Schema\Contract\SchemaManagerContract;

class SchemaManager implements SchemaManagerContract
{

	/**
	* @var 		$platformProvider
	* @access 	protected
	*/
	protected 	$platformProvider;

	/**
	* @var 		$connectionId
	* @access 	protected
	*/
	protected static $connectionId;

	/**
	* @var 		$processor
	* @access  	protected
	*/
	protected 	$processor;

	/**
	* @var 		$queryBuilder
	* @access 	protected
	*/
	protected 	$queryBuilder;

	/**
	* {@inheritDoc}
	*/
	public function __construct(String $connectionId=null, QueryBuilder $queryBuilder)
	{
		$this->queryBuilder = $queryBuilder;
	}

	/**
	* {@inheritDoc}
	*/
	public static function __callStatic($method, $parameters)
	{
		//
	}

	/**
	* {@inheritDoc}
	*/
	public function createDatabase(String $databaseName)
	{
		return $this->runQueryWithExpression(Expressions::createDatabase($databaseName), 0);
	}

	/**
	* {@inheritDoc}
	*/
	public function createDatabaseIfNotExist(String $databaseName)
	{
		return $this->runQueryWithExpression(Expressions::createDatabaseIfNotExist($databaseName));
	}

	/**
	* {@inheritDoc}
	*/
	public function switchDatabase(String $databaseName)
	{
		return $this->runQueryWithExpression(Expressions::switchDatabase($databaseName));
	}

	/**
	* {@inheritDoc}
	*/
	public function dropDatabase(String $databaseName)
	{
		return $this->runQueryWithExpression(Expressions::dropDatabase($databaseName));
	}

	/**
	* {@inheritDoc}
	*/
	public function hasTable(String $table) : Bool
	{
		return SchemaManager::table($table)->exists();
	}

	/**
	* {@inheritDoc}
	*/
	public function getAllTables()
	{
		return $this->queryBuilder->queryWithBinding(Expressions::allTables())->get()->all();
	}

	/**
	* {@inheritDoc}
	*/
	public function hasColumn(String $table, String $column) : Bool
	{
		return SchemaManager::table($table)->hasColumn($column);
	}

	/**
	* {@inheritDoc}
	*/
	public function getColumns(String $table)
	{
		return SchemaManager::table($table)->getColumns();
	}

	/**
	* {@inheritDoc}
	*/
	public function getColumnNames(String $table)
	{
		return SchemaManager::table($table)->getColumnNames();
	}

	/**
	* {@inheritDoc}
	*/
	public function getColumnTypes(String $table)
	{
		return SchemaManager::table($table)->getColumnTypes();
	}

	/**
	* {@inheritDoc}
	*/
	public function getColumnType(String $table, String $columnName)
	{
		if ($column = $this->getColumn($table, $columnName)) {
			return $column->Type;
		}
	}

	/**
	* {@inheritDoc}
	*/
	public function getColumn(String $table, String $columnName) : Column
	{
		return SchemaManager::table($table)->getColumn($columnName);
	}

	/**
	* {@inheritDoc}
	*/
	public function hasForeign(String $table, String $foreignKey) : Bool
	{
		return SchemaManager::table($table)->hasForeign($foreignKey);
	}

	/**
	* {@inheritDoc}
	*/
	public function dropForeign(String $table, String $foreignKey) : Bool
	{
		return SchemaManager::table($table)->dropForeign($foreignKey);
	}

	/**
	* Holds instance of table.
	*
	* @param 	$table <String>
	* @access 	public
	* @static
	* @return 	void
	*/
	public static function table(String $table)
	{
		return Table::getInstance($table);
	}

	/**
	* {@inheritDoc}
	*/
	public function setTableEngine(String $engine)
	{
		return SchemaManager::table($table)->setEngine($engine);
	}

	/**
	* @param 	$expression <String>
	* @param 	$type <Integer>
	* @access 	protected
	* @return 	Mixed
	*/
	protected function runQueryWithExpression(String $expresison, int $type=1)
	{
		return $this->queryBuilder->query($expresison, $type);
	}
}