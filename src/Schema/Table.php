<?php
namespace Kit\Glider\Schema;

use Closure;
use RuntimeException;
use Kit\Glider\Factory;
use Kit\Glider\Schema\Scheme;
use Kit\Glider\Schema\Column;
use Kit\Glider\Schema\Expressions;
use Kit\Glider\Schema\Contract\BaseTableContract;

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
	public function __construct(String $tableName, Array $columns=[], Array $indexes=[], String $primaryKey=null)
	{
		$this->tableName = $tableName;
		$this->columns = $columns;
		$this->indexes = $indexes;
		$this->primaryKey = $primaryKey;
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

			$_columns[] = Factory::getPlatformColumn($column);

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
				return Factory::getPlatformColumn($column);
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

				return Factory::getProvider()->columnIndex($index);

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
	public function renameIndex(String $oldname, String $newName)
	{
		//
	}

	/**
	* @param 	$tableName <String>
	* @access 	public
	* @return 	Object
	* @static
	*/
	public static function getInstance(String $tableName=null)
	{
		return new self($tableName);
	}

	/**
	* @param 	$column <String>
	* @access 	protected
	* @return 	Mixed
	*/
	protected function modifyColumn(String $column)
	{
		return $this->runQueryWithExpression(Expressions::modifyColumn($this->tableName, $column));
	}

	/**
	* @param 	$column <String>
	* @access 	protected
	* @return 	Mixed
	*/
	protected function addColumn(String $column)
	{
		return $this->runQueryWithExpression(Expressions::addColumn($this->tableName, $column));
	}

	/**
	* @access 	protected
	* @return 	Kit\Glider\Query\Builder\QueryBuilder
	*/
	protected function builder()
	{
		return Factory::getQueryBuilder();
	}

	/**
	* @param 	$column <Mixed>
	* @access 	protected
	* @return 	String
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
	* @param 	$expression <String>
	* @param 	$type <Integer>
	* @access 	protected
	* @return 	Mixed
	*/
	protected function runQueryWithExpression(String $expresison, int $type=1)
	{
		return $this->builder()->query($expresison, $type);
	}

	/**
	* @param 	$table <String>
	* @param 	$key <String>
	* @access 	protected
	* @return 	Mixed
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

}