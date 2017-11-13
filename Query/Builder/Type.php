<?php
namespace Glider\Query\Builder;

abstract class Type
{

	/**
	* This method gets and returns the statement type.
	*
	* @param 	$query <String>
	* @access 	public
	* @return 	Integer
	*/
	public static function getStatementType(String $query) : Int
	{
		$type = 0;
		if (preg_match("/^SELECT|select|Select([^ ]+)/", $query)) {
			$type = 1;
		}

		if (preg_match("/^INSERT([^ ]+)/", $query)) {
			$type = 2;
		}

		if (preg_match("/^UPDATE([^ ]+)/", $query)) {
			$type = 3;
		}

		if (preg_match("/^DELETE([^ ]+)/", $query)) {
			$type = 4;
		}

		return $type;
	}

}