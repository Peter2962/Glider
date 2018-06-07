<?php
/**
* @author 		Peter Taiwo <peter@phoxphp.com>
* @package 		Kit\Glider\Statements\Platforms\MysqliStatement
* @license 		MIT License
*
* Permission is hereby granted, free of charge, to any person obtaining a copy
* of this software and associated documentation files (the "Software"), to deal
* in the Software without restriction, including without limitation the rights
* to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
* copies of the Software, and to permit persons to whom the Software is
* furnished to do so, subject to the following conditions:
*
* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
* IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
* FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
* AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
* LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
* OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
* SOFTWARE.
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