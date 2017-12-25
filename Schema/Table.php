<?php
namespace Glider\Schema;

use Closure;
use Glider\Factory;
use RuntimeException;
use Glider\Schema\Column;
use Glider\Schema\Scheme;
use Glider\Schema\Expressions;
use Glider\Schema\Contract\BaseTableContract;

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
	public function drop() {

	}

	/**
	* {@inheritDoc}
	*/
	public function rename(String $newName)
	{

	}

	/**
	* {@inheritDoc}
	*/
	public function hasColumn($column) : Bool
	{
		$columnName = $this->_column($column);

		if ($result = $this->runQueryWithExpression(Expressions::hasColumn($this->tableName, $columnName))) {
			if ($result->numRows() > 0) {
				return true;
			}

			return false;
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
		return $this->builder()->queryWithBinding(Expressions::getColumns($this->tableName))->get()->all();
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
				return new Column($column);
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
	* @access 	protected
	* @return 	Glider\Query\Builder\QueryBuilder
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
			throw new RuntimeException(sprintf('Column must either be a string or instance of %s', 'Glider\Schema\Column'));
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