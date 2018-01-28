<?php
/**
* MIT License
* Permission is hereby granted, free of charge, to any person obtaining a copy
* of this software and associated documentation files (the "Software"), to deal
* in the Software without restriction, including without limitation the rights
* to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
* copies of the Software, and to permit persons to whom the Software is
* furnished to do so, subject to the following conditions:

* The above copyright notice and this permission notice shall be included in all
* copies or substantial portions of the Software.

* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
* IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
* FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
* AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
* LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
* OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
* SOFTWARE.
*/

namespace Kit\Glider\Schema\Column\Index;

use StdClass;
use Kit\Glider\Schema\Column\Index\Contract\IndexContract;

class MysqliIndex implements IndexContract
{

	/**
	* @var 		$index
	* @access 	protected
	*/
	protected 	$index;

	/**
	* {@inheritDoc}
	*/
	public function __construct(StdClass $index)
	{
		$this->index = $index;
	}

	/**
	* {@inheritDoc}
	*/
	public function getTable() : String
	{
		return $this->index->Table;
	}

	/**
	* {@inheritDoc}
	*/
	public function getName() : String
	{
		return $this->index->Key_name;
	}

	/**
	* {@inheritDoc}
	*/
	public function getSequence() : int
	{
		return $this->index->Seq_in_index;
	}

	/**
	* {@inheritDoc}
	*/
	public function isUnique() : Bool
	{
		return ($this->index->Non_unique == 0) ? true : false;
	}

	/**
	* {@inheritDoc}
	*/
	public function isNull() : Bool
	{
		return (strtolower($this->index->Null) == 'yes') ? true : false;
	}

	/**
	* {@inheritDoc}
	*/
	public function getColumnName() : String
	{
		return $this->index->Column_name;
	}
}