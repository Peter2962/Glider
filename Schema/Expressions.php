<?php
namespace Glider\Schema;

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

}