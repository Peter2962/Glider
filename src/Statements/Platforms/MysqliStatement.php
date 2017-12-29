<?php
/**
* @author 	Peter Taiwo
* @package 	Kit\Glider\Statements\Platforms\MysqliStatement
*/

namespace Kit\Glider\Statements\Platforms;

use Kit\Glider\Statements\Contract\StatementContract;

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
	public function __construct($statement)
	{
		if ($statement == false) {
			return $statement;
		}

		$this->statement = $statement;
	}

	/**
	* {@inheritDoc}
	*/
	public function affectedRows() : int
	{
		return $this->statement->affected_rows;
	}

	/**
	* {@inheritDoc}
	*/
	public function errno() : int
	{
		return $this->statement->errno;
	}

	/**
	* {@inheritDoc}
	*/
	public function errorList()
	{
		return $this->statement->error_list;
	}

	/**
	* {@inheritDoc}
	*/
	public function error()
	{
		return $this->statement->error;
	}

	/**
	* {@inheritDoc}
	*/
	public function fieldCount() : int
	{
		return $this->statement->field_count;
	}

	/**
	* {@inheritDoc}
	*/
	public function insertId()
	{
		return $this->statement->insert_id;
	}

	/**
	* {@inheritDoc}
	*/
	public function paramCount() : int
	{
		return $this->statement->param_count;
	}

	/**
	* {@inheritDoc}
	*/
	public function sqlState() : int
	{
		return $this->statement->sqlstate;
	}	

}