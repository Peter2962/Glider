<?php
namespace Glider\Schema;

class Expressions
{
	
	/**
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

}