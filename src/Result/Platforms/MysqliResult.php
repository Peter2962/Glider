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

namespace Kit\Glider\Result\Platforms;

use mysqli_result;
use Kit\Glider\Result\Contract\PlatformResultContract;

class MysqliResult implements PlatformResultContract
{

	/**
	* @var 		$result
	* @access 	protected
	*/
	protected 	$result;

	/**
	* @param 	$result <Mixed>
	* @access 	public
	* @return 	void
	*/
	public function __construct($result)
	{
		$this->result = $result;
	}

	/**
	* {@inheritDoc}
	*/
	public function numRows() : int
	{
		return $this->_get('num_rows');
	}

	/**
	* {@inheritDoc}
	*/
	public function lengths() : int
	{
		return $this->_get('lengths');
	}

	/**
	* {@inheritDoc}
	*/
	public function fieldCount() : int
	{
		return $this->_get('field_count');
	}

	/**
	* {@inheritDoc}
	*/
	public function fetchArray()
	{
		//
	}

	/**
	* {@inheritDoc}
	*/
	public function fetchObject()
	{
		return $this->_get('fetch_object', false);
	}

	/**
	* {@inheritDoc}
	*/
	public function fetchAll()
	{
		return $this->_get('fetch_all', false);
	}

	/**
	* @param 	$key <String>
	* @param 	$isProperty <Boolean>
	* @access 	protected
	* @return 	Mixed
	*/
	protected function _get(String $key, Bool $isProperty=true)
	{
		if ($this->result instanceof mysqli_result) {
			if ($isProperty == false) {
				return $this->result->$key();
			}

			return $this->result->$key;
		}

		return false;
	}

}