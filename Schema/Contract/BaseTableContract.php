<?php
namespace Glider\Schema\Contract;

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

}