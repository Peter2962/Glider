<?php
namespace Kit\Glider\Schema;

class Expressions
{
	
	/**
	* @param 	$table <String>
	* @access 	public
	* @return 	String
	*/
	public static function showTable(String $table) : String
	{
		return 'SHOW TABLES LIKE ' . '"' . $table . '"';
	}

	/**
	* @access 	public
	* @return 	String
	* @static
	*/
	public static function allTables() : String
	{
		return 'SHOW TABLES';
	}

	/**
	* @param 	$table <String>
	* @param 	$column <String>
	* @access 	public
	* @return 	String
	* @static
	*/
	public static function hasColumn(String $table, String $column) : String
	{
		return 'SHOW COLUMNS FROM ' . $table . ' LIKE ' . '"' . $column . '"';
	}

	/**
	* @param 	$table <String>
	* @param 	$column <String>
	* @access 	public
	* @return 	String
	* @static
	*/
	public static function dropColumn(String $table, String $column) : String
	{
		return 'ALTER TABLE ' . $table . ' DROP COLUMN ' . $column;
	}

	/**
	* @param 	$table <String>
	* @param 	$oldColumn <String>
	* @param 	$newColumn <String>
	* @access 	public
	* @return 	String
	* @static
	*/
	public static function renameColumn(String $table, String $oldColumn, String $newColumn) : String
	{
		return 'ALTER TABLE ' . $table . ' CHANGE ' . $oldColumn . ' ' . $newColumn;
	}

	/**
	* @param 	$table <String>
	* @access 	public
	* @return 	String
	* @static
	*/
	public static function getColumns(String $table) : String
	{
		return 'SHOW COLUMNS FROM ' . $table;
	}

	/**
	* @param 	$databaseName <String>
	* @access 	public
	* @return 	String
	* @static
	*/
	public static function createDatabase(String $databaseName) : String
	{
		return 'CREATE DATABASE ' . $databaseName;
	}

	/**
	* @param 	$databaseName <String>
	* @access 	public
	* @return 	String
	* @static
	*/
	public static function createDatabaseIfNotExist(String $databaseName) : String
	{
		return 'CREATE DATABASE IF NOT EXISTS ' . $databaseName;
	}

	/**
	* @param 	$databaseName <String>
	* @access 	public
	* @return 	String
	* @static
	*/
	public static function switchDatabase(String $databaseName) : String
	{
		return 'USE ' . $databaseName;
	}

	/**
	* @param 	$databaseName <String>
	* @access 	public
	* @return 	String
	* @static
	*/
	public static function dropDatabase(String $databaseName) : String
	{
		return 'DROP DATABASE IF EXISTS ' . $databaseName;
	}

	/**
	* @param 	$table <String>
	* @param 	$engine <String>
	* @access 	public
	* @return 	String
	* @static
	*/
	public static function setEngine(String $table, String $engine) : String
	{
		return 'ALTER TABLE ' . $table . ' ENGINE = ' . $engine;
	}

	/**
	* @param 	$table <String>
	* @param 	$definition <Mixed>
	* @access 	public
	* @return 	String
	* @static
	*/
	public static function createTable(String $table, $definition) : String
	{
		if (is_array($definition)) {

			$definition = implode(',', $definition);

		}

		return 'CREATE TABLE IF NOT EXISTS ' . $table . '(' . $definition . ')';
	}

	/**
	* @param 	$table <String>
	* @access 	public
	* @return 	String
	* @static
	*/
	public static function dropTable(String $table) : String
	{
		return 'DROP TABLE IF EXISTS ' . $table;
	}

	/**
	* @param 	$table <String>
	* @param 	$newName <String>
	* @access 	public
	* @return 	String
	* @static
	*/
	public static function renameTable(String $table, String $newName) : String
	{
		return 'RENAME TABLE ' . $table . ' TO ' . $newName;
	}

	/**
	* @access 	public
	* @return 	String
	* @static
	*/
	public static function getAllIndexes(String $table)
	{
		return 'SHOW INDEXES FROM ' . $table;
	}

	/**
	* @param 	$table <String>
	* @param 	$index <String>
	* @access 	public
	* @return 	String
	* @static
	*/
	public static function addIndex(String $table, String $index) : String
	{
		return 'ALTER TABLE ' . $table . ' ADD ' . $index;
	}

	/**
	* @param 	$table <String>
	* @param 	$index <String>
	* @access 	public
	* @return 	String
	* @static
	*/
	public static function dropIndex(String $table, String $index) : String
	{
		return 'ALTER TABLE ' . $table . ' DROP INDEX ' . $index;
	}

	/**
	* @param 	$table <String>
	* @param 	$column <String>
	* @access 	public
	* @return 	String
	* @static
	*/
	public static function modifyColumn(String $table, String $column) : String
	{
		return 'ALTER TABLE ' . $table . ' MODIFY COLUMN ' . $column;
	}

	/**
	* @param 	$table <String>
	* @param 	$column <String>
	* @access 	public
	* @return 	String
	* @static
	*/
	public static function addColumn(String $table, String $column) : String
	{
		return 'ALTER TABLE ' . $table . ' ADD COLUMN ' . $column;
	}

	/**
	* @param 	$table <String>
	* @param 	$column <String>
	* @access 	public
	* @return 	String
	* @static
	*/
	public static function addPrimary(String $table, String $column) : String
	{
		return 'ALTER TABLE ' . $table . ' ADD PRIMARY KEY (' . trim($column) . ')';
	}

	/**
	* @param 	$table <String>
	* @access 	public
	* @return 	String
	* @static
	*/
	public static function dropPrimary(String $table) : String
	{
		return 'ALTER TABLE ' . $table . ' DROP PRIMARY KEY';
	}

}