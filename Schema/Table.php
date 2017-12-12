<?php
namespace Glider\Schema;

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

}