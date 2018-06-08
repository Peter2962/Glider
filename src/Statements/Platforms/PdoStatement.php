<?php
/**
* @author 		Peter Taiwo <peter@phoxphp.com>
* @package 		Kit\Glider\Statements\Platforms\PdoStatement
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

use PDO;
use Kit\Glider\Statements\Contract\StatementContract;
use Kit\Glider\Statements\Platforms\AbstractPdoPlatformStatement;

class PdoStatement extends AbstractPdoPlatformStatement implements StatementContract
{

	/**
	* {@inheritDoc}
	*/
	public function __construct($statement)
	{
		$this->statement = $statement;
	}

	/**
	* {@inheritDoc}
	*/
	public function affectedRows() : int
	{
		return (int) $this->statement->rowCount();
	}

	/**
	* {@inheritDoc}
	*/
	public function errno() : int
	{
		return (int) $this->statement->errorCode();
	}

	/**
	* {@inheritDoc}
	*/
	public function errorList()
	{
		return $this->statement->errorInfo();
	}

	/**
	* {@inheritDoc}
	*/
	public function error()
	{
		return $this->errorList()[2];
	}

	/**
	* {@inheritDoc}
	*/
	public function fieldCount() : int
	{
		return (int) $this->statement->columnCount();
	}

	/**
	* {@inheritDoc}
	*/
	public function insertId() : int
	{
		return $this->statement->lastInsertId;
	}

	/**
	* {@inheritDoc}
	*/
	public function paramCount() : int
	{
		return $this->fieldCount();
	}

	/**
	* {@inheritDoc}
	*/
	public function sqlState() : int
	{
		return $this->errorInfo()[0];
	}

	/**
	* {@inheritDoc}
	*/
	public function fetch()
	{
		return $this->statement->fetch(PDO::FETCH_OBJ);
	}

	/**
	* {@inheritDoc}
	*/
	public function fetchAll()
	{
		return $this->statement->fetchAll();
	}

	/**
	* {@inheritDoc}
	*/
	public function fetchColumn()
	{
		return $this->statement->fetchColumn();
	}

	/**
	* {@inheritDoc}
	*/
	public function fetchObject()
	{
		return $this->statement->fetchObject();
	}

	/**
	* {@inheritDoc}
	*/
	public function fetchWithClass(String $className)
	{
		return $this->statement->fetchAll(PDO::FETCH_CLASS, $className);
	}

}