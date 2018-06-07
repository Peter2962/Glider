<?php
/**
* @author 		Peter Taiwo <peter@phoxphp.com>
* @package 		Kit\Glider\Schema\Table
* @license 		MIT License
*
* Permission is hereby granted, free of charge, to any person obtaining a copy
* of this software and associated documentation files (the "Software"), to deal
* in the Software without restriction, including without limitation the rights
* to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
* copies of the Software, and to permit persons to whom the Software is
* furnished to do so, subject to the following conditions:
*
* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
* IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
* FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
* AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
* LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
* OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
* SOFTWARE.
*/

namespace Kit\Glider\Schema;

use Closure;
use RuntimeException;
use Kit\Glider\Repository;
use Kit\Glider\Schema\Scheme;
use Kit\Glider\Schema\Column;
use Kit\Glider\Schema\Expressions;
use Kit\Glider\Schema\Contract\BaseTableContract;
use Kit\Glider\Schema\Column\Contract\ColumnContract;
use Kit\Glider\Schema\Column\Index\Contract\IndexContract;

class Table implements BaseTableContract
{

	/**
	* @var 		$tableName
	* @access 	protected
	*/
	protected 	$tableName;

	/**
	* @var 		$columns
	* @access 	protected
	*/
	protected 	$columns;

	/**
	* @var 		$indexes
	* @access 	protected
	*/
	protected 	$indexes;

	/**
	* @var 		$primaryKey
	* @access 	protected
	*/
	protected 	$primaryKey;
	
	/**
	* {@inheritDoc}
	*/	
	public function __construct(String $tableName)
	{
		$this->tableName = $tableName;
	}

	/**
	* {@inheritDoc}
	*/
	public function setEngine(String $engine)
	{
		if (!in_array($engine, $this->engines())) {
			throw new RuntimeException(sprintf('%s engine is not supported.'));
		}

		return $this->runQueryWithExpression(Expressions::setEngine($this->tableName, $engine), 0);
	}

	/**
	* {@inheritDoc}
	*/
	public function exists()
	{
		$hasTable = $this->builder()->query(Expressions::showTable($this->tableName));
		if ($hasTable && $hasTable->numRows() > 0) {
			return true;
		}

		return false;
	}

	/**
	* {@inheritDoc}
	*/
	public function create(Closure $scheme)
	{
		$schemeObject = new Scheme();

		$create = function() use ($scheme, $schemeObject) {

			return $scheme($schemeObject);

		};

		$create();
		$commands = $schemeObject->getDefinition();
		$expresison = Expressions::createTable($this->tableName, $commands);

		return $this->runQueryWithExpression($expresison);
	}

	/**
	* {@inheritDoc}
	*/
	public function modify(Closure $scheme)
	{
		$schemeObject = new Scheme();

		$create = function() use ($scheme, $schemeObject) {

			return $scheme($schemeObject);

		};

		$create();
		$commands = $schemeObject->getCommandsArray();
		$commandKeys = array_keys($commands);

		if (sizeof($commandKeys) < 1) {

			return null;

		}

		array_map(function($key) use ($commands) {

			$command = $commands[$key];

			if (!in_array($command['type'], ['INDEX', 'UNIQUE_INDEX', 'FOREIGN'])) {

				if ($this->hasColumn($key)) {

					$this->modifyColumn($commands[$key]['definition']);

				}else{

					// Create column if it does not exist in table.
					$this->addColumn($commands[$key]['definition']);

				}
			}else{
				switch ($command['type']) {
					case 'FOREIGN':
						$this->addForeign($command['definition']);
					break;
				}
			}

		}, $commandKeys);
	}

	/**
	* {@inheritDoc}
	*/
	public function drop() {
		return $this->runQueryWithExpression(Expressions::dropTable($this->tableName));
	}

	/**
	* {@inheritDoc}
	*/
	public function rename(String $newName)
	{
		return $this->runQueryWithExpression(Expressions::renameTable($this->tableName, $newName));
	}

	/**
	* {@inheritDoc}
	*/
	public function dropColumn(String $column)
	{
		return $this->runQueryWithExpression(Expressions::dropColumn($this->tableName, $column));
	}

	/**
	* {@inheritDoc}
	*/
	public function hasColumn($column) : Bool
	{
		$columnName = $this->_column($column);

		foreach($this->getColumns() as $col) {

			if ($col->getName() == $column) {

				return true;

			}

		}

		return false;
	}

	/**
	* Returns columns in a table.
	*
	* @access 	public
	* @return 	Mixed
	*/
	public function getColumns()
	{
		$columns = $this->builder()->queryWithBinding(Expressions::getColumns($this->tableName))->get()->all();

		$_columns = [];

		foreach($columns as $column) {

			$_columns[] = Repository::getPlatformColumn($column);

		}

		return $_columns;
	}

	/**
	* {@inheritDoc}
	*/
	public function getColumn($column) : Column
	{
		$columnName = $this->_column($column);

		if (!$columns = $this->getColumns($this->tableName)) {
			return false;
		}

		foreach($columns as $column) {
			if ($column->Field == $columnName) {
				return Repository::getPlatformColumn($column);
			}
		}	
	}

	/**
	* {@inheritDoc}
	*/
	public function getColumnNames()
	{
		return $this->getColumnKeys('Field');
	}

	/**
	* {@inheritDoc}
	*/
	public function getColumnTypes()
	{
		return $this->getColumnKeys('Type');
	}

	/**
	* {@inheritDoc}
	*/
	public function getColumnType(String $column)
	{
		if ($column = $this->getColumn($columnName)) {
			return $column->Type;
		}
	}

	/**
	* {@inheritDoc}
	*/
	public function renameColumn(String $column, String $newName)
	{
		$columnObject = $this->getColumn($column);
		$newColumn = $newName . ' ' . $columnObject->getType();

		$length = (Int) $columnObject->getLength();

		if ($length > 0) {

			$newColumn = $newColumn . '(' . $length .')';

		}

		return $this->runQueryWithExpression(Expressions::renameColumn($this->tableName, $column, $newColumn));
	}

	/**
	* {@inheritDoc}
	*/
	public function getAllIndexes()
	{
		if ($result = $this->builder()->queryWithBinding(Expressions::getAllIndexes($this->tableName))->get()) {

			return array_map(function($index) {

				return Repository::getProvider()->columnIndex($index);

			}, $result->all());

		}

		return false;
	}

	/**
	* {@inheritDOc}
	*/
	public function hasIndex(String $name) : Bool
	{
		$indexes = $this->getAllIndexes();

		foreach($indexes as $index) {

			if ($name == $index->getName()) {

				return true;

			}

		}

		return false;
	}

	/**
	* {@inheritDoc}
	*/
	public function getIndex(String $indexName)
	{
		foreach($this->getAllIndexes() as $index) {

			if ($indexName == $index->getName()) {

				return $index;

			}

		}

		return false;
	}

	/**
	* {@inheritDoc}
	*/
	public function addIndex(String $name, Array $columns=[], int $setUnique=0)
	{

		$index = 'INDEX ' . $name . '(' . implode(',', $columns) . ')';

		$type = 'INDEX';

		if ($setUnique == Scheme::SET_UNIQUE_KEY) {

			$index = 'UNIQUE ' . $index;

			$type = 'UNIQUE_INDEX';

		}

		return $this->runQueryWithExpression(Expressions::addIndex($this->tableName, $index));
	}

	/**
	* {@inheritDoc}
	*/
	public function dropIndex($index)
	{
		if ($index instanceof IndexContract) {

			$index = $index->getName();

		}

		return $this->runQueryWithExpression(Expressions::dropIndex($this->tableName, $index));
	}

	/**
	* {@inheritDoc}
	*/
	public function isUnique($index) : Bool
	{
		if (is_string($index)) {

			if (!$this->hasIndex($index)) {

				throw new RuntimeException(sprintf('Index `%s` does not exist in `%s` table', $index, $this->tableName));

			}

			$index = $this->getIndex($index);

		}

		if ($index->isUnique()) {

			return true;

		}

		return false;
	}

	/**
	* {@inheritDoc}
	*/
	public function addPrimary($column)
	{
		if (is_string($column) && !$this->hasColumn($column)) {

			throw new RuntimeException(sprintf('Column `%s` does not exist in `%s` table', $column, $this->tableName));

		}

		if ($column instanceof ColumnContract) {

			$column = $column->getName();

		}

		return $this->runQueryWithExpression(Expressions::addPrimary($this->tableName, $column));
	}

	/**
	* {@inheritDoc}
	*/
	public function dropPrimary()
	{
		return $this->runQueryWithExpression(Expressions::dropPrimary($this->tableName));
	}

	/**
	* {@inheritDoc}
	*/
	public function hasForeign(String $foreignKey) : Bool
	{
		if ($result = $this->runQueryWithExpression(Expressions::showCreateTable($this->tableName))) {
			if (is_object($result) && method_exists($result, 'fetchObject')) {
				$query = $result->fetchObject()->{'Create Table'};
				$foreignKey = 'CONSTRAINT `' . $foreignKey . '`';

				if (preg_match("/$foreignKey/", $query)) {
					return true;
				}
			}
		}

		return false;
	}

	/**
	* {@inheritDoc}
	*/
	public function dropForeign(String $foreignKey) : Bool
	{
		if (!$this->hasForeign($foreignKey)) {
			return false;
		}

		$this->runQueryWithExpression(Expressions::dropForeign($this->tableName, $foreignKey));

		return true;
	}

	/**
	* Get an instace of table class.
	*
	* @param 	$tableName <String>
	* @access 	public
	* @return 	<Object> <Kit\Glider\Schema\Table>
	* @static
	*/
	public static function getInstance(String $tableName)
	{
		return new self($tableName);
	}

	/**
	* @param 	$column <String>
	* @access 	protected
	* @return 	<Mixed>
	*/
	protected function modifyColumn(String $column)
	{
		return $this->runQueryWithExpression(Expressions::modifyColumn($this->tableName, $column));
	}

	/**
	* @param 	$column <String>
	* @access 	protected
	* @return 	<Mixed>
	*/
	protected function addColumn(String $column)
	{
		return $this->runQueryWithExpression(Expressions::addColumn($this->tableName, $column));
	}

	/**
	* Returns instance of query builder
	*
	* @param 	$connectionId <String>
	* @access 	protected
	* @return 	<Object> <Kit\Glider\Query\Builder\QueryBuilder>
	*/
	protected function builder(String $connectionId=null)
	{
		return Repository::getQueryBuilder($connectionId);
	}

	/**
	* @param 	$column <Mixed>
	* @access 	protected
	* @return 	<String>
	*/
	protected function _column($column)
	{
		if (!is_string($column) && !$column instanceof Column) {
			throw new RuntimeException(sprintf('Column must either be a string or instance of %s', 'Kit\Glider\Schema\Column'));
		}

		$name = $column;

		if ($column instanceof Column) {
			$name = $column->getName();
		}

		return $name;
	}

	/**
	* Processes a raw query.
	*
	* @param 	$expression <String>
	* @param 	$type <Integer>
	* @access 	protected
	* @return 	<Mixed>
	*/
	protected function runQueryWithExpression(String $expresison, int $type=1)
	{
		return $this->builder()->query($expresison, $type);
	}

	/**
	* @param 	$table <String>
	* @param 	$key <String>
	* @access 	protected
	* @return 	<Mixed>
	*/
	protected function getColumnKeys(String $key)
	{
		if (!$columns = $this->getColumns()) {
			return false;
		}

		$keys = array_map(function($column) use ($key) {
			if (isset($column->$key)) {
				return $column->$key;
			}
		}, $columns);

		return $keys;
	}

	/**
	* @access 	protected
	* @return 	Array
	*/
	protected function engines() : Array
	{
		return ['InnoDB', 'MyISAM', 'CSV'];
	}

	/**
	* Add foreign key to table.
	*
	* @param 	$definition <String>
	* @access 	protected
	* @return 	<void>
	*/
	protected function addForeign(String $definition)
	{
		$this->runQueryWithExpression(Expressions::addForeign($this->tableName, $definition));
	}

}