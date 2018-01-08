<?php
namespace Kit\Glider\Schema\Contract;

use Closure;
use Kit\Glider\Schema\Column\Index\Contract\IndexContract;

interface BaseTableContract
{

	/**
	* Construct a new table.
	*
	* @param 	$tableName <String>
	* @param 	$columns <Array>	
	* @param 	$indexes <Array>
	* @param 	$primaryKey <String>
	* @access 	public
	* @return 	void
	*/
	public function __construct(String $tableName, Array $columns=[], Array $indexes=[], String $primaryKey=null);

	/**
	* Sets the table engine.
	*
	* @param 	$engine <String>
	* @access 	public
	* @return 	Mixed
	*/
	public function setEngine(String $engine);

	/**
	* Checks if a table exists.
	*
	* @access 	public
	* @return 	Boolean
	*/
	public function exists();

	/**
	* Creates a table.
	*
	* Basic Usage:
	*
	* Schema::table('mytable')->create(function($scheme){
	* 		// definitions
	* 		$scheme->integer('id', false, true, [// options]);
	* });
	*
	* @param 	$scheme <Closure>
	* @access 	public
	* @return 	Mixed
	* @see 		Kit\Glider\Schema\Scheme
	*/
	public function create(Closure $scheme);

	/**
	* Modifies or alters a table.
	*
	* Basic Usage:
	*
	* Schema::table('mytable')->modify(function($scheme){
	* 		// definitions
	* 		$scheme->integer('id', false, true, [// options]);
	* });
	*
	* @param 	$scheme <Closure>
	* @access 	public
	* @return 	Mixed
	*/
	public function modify(Closure $scheme);

	/**
	* Drops table.
	*
	* @access 	public
	* @return 	Mixed
	*/
	public function drop();

	/**
	* Renames table.
	*
	* @param 	$newName <String>
	* @access 	public
	* @return 	Mixed
	*/
	public function rename(String $newName);

	/**
	* Checks if a table has column.
	*
	* @param 	$column <String>|<Kit\Glider\Schema\Column>
	* @access 	public
	* @return 	Boolean
	*/
	public function hasColumn($column) : Bool;

	/**
	* Return table columns.
	*
	* @access 	public
	* @return 	Mixed
	*/
	public function getColumns();

	/**
	* Return name of columns.
	*
	* @access 	public
	* @return 	Mixed
	*/
	public function getColumnNames();

	/**
	* Return types of columns with length.
	*
	* @access 	public
	* @return 	Mixed
	*/
	public function getColumnTypes();

	/**
	* Return type of a column.
	*
	* @access 	public
	* @return 	Mixed
	*/
	public function getColumnType(String $column);

	/**
	* Return table column.
	*
	* @param 	$column <Mixed> String|Kit\Glider\Schema\Column
	* @access 	public
	* @return 	Mixed
	*/
	public function getColumn($column);

	/**
	* Renames a column.
	*
	* @param 	$column <String>
	* @param 	$newName <String>
	* @access 	public
	* @return 	Mixed
	*/
	public function renameColumn(String $column, String $newName);

	/**
	* Returns all indexes on a table.
	*
	* @access 	public
	* @return 	Mixed
	*/
	public function getAllIndexes();

	/**
	* Checks if a table has column.
	*
	* @param 	$column <String>
	* @access 	public
	* @return 	void
	*/
	public function hasIndex(String $column) : Bool;

	/**
	* Returns an index in a table.
	*
	* @param 	$index <String>
	* @access 	public
	* @return 	Mixed
	*/
	public function getIndex(String $index);

	/**
	* Creates a new index.
	*
	* @param 	$name <String>
	* @param 	$columns <Array>
	* @param 	$setUnique <Integer>
	* @access 	public
	* @return 	void
	*/
	public function addIndex(String $name, Array $columns=[], int $setUnique);

	/**
	* Drops an index on a table.
	*
	* @param 	$index <Mixed>
	* @access 	public
	* @return 	Mixed
	*/
	public function dropIndex($index);

	/**
	* Checks if an index is unique. This method accepts one argument which can eother be
	* a string or an instance of IndexContract.
	*
	* @param 	$index <Mixed>
	* @access 	public
	* @return 	Boolean
	*/
	public function isUnique($index) : Bool;

	/**
	* Creates a primary key on the table. Method accepts one argument that can either be a string
	* or an instance of ColumnContract
	*
	* @param 	$column <Mixed>
	* @access 	public
	* @return 	Mixed
	*/
	public function addPrimary($column);

	/**
	* Drops a primary key on the table.
	*
	* @access 	public
	* @return 	Mixed
	*/
	public function dropPrimary();

}