<?php
/**
* @author 	Peter Taiwo
* @package 	Glider\Statements\Platforms\MysqliStatement
*/

namespace Glider\Statements\Platforms;

use Glider\Statements\Contract\StatementContract;

class MysqliStatement implements StatementContract
{

	/**
	* @var 		$statement
	* @access 	protected
	*/
	protected 	$statement;

	/**
	* {@inheritDoc}
	*/
	public function __construct(mysqli_stmt $statement)
	{
		$this->statement = $statement;
	}

	/**
	* {@inheritDoc}
	*/
	public function affectedRows() : int
	{

	}

	/**
	* {@inheritDoc}
	*/
	public function errno() : int
	{
		
	}

	/**
	* {@inheritDoc}
	*/
	public function errorList()
	{

	}

	/**
	* {@inheritDoc}
	*/
	public function error()
	{

	}

	/**
	* {@inheritDoc}
	*/
	public function fieldCount() : int
	{

	}

	/**
	* {@inheritDoc}
	*/
	public function insertId()
	{

	}

	/**
	* {@inheritDoc}
	*/
	public function paramCount() : int
	{

	}

	/**
	* {@inheritDoc}
	*/
	public function sqlState() : int
	{

	}	

}