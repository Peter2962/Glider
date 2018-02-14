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

/**
* @author 	Peter Taiwo
* @package 	Kit\Glider\Query\Parameters
*
* This class helps to set and get query parameters.
*/

namespace Kit\Glider\Query;

class Parameters
{

	/**
	* @var 		$parameters
	* @access 	private
	*/
	private 	$parameters = [];

	/**
	* Sets a parameter key and value.
	*
	* @param 	$key <String>
	* @param 	$value <Mixed>
	* @param 	$override <Boolean> If this option is set to true, the parameter value will be
	* 			overriden if a value has already been set.
	* @access 	public
	* @return 	void
	*/
	public function setParameter(String $key, $value, Bool $override=false)
	{
		if ($this->getParameter($key)) {
			$defValue = $this->getParameter($key);
			$this->parameters[$key] = [$defValue];
			$this->parameters[$key][] = $value;
			return;
		}

		$this->parameters[$key] = $value;
	}

	/**
	* Returns a parameter value given it's key.
	*
	* @param 	$key <String>
	* @access 	public
	* @return 	Mixed
	*/
	public function getParameter(String $key)
	{
		return $this->parameters[$key] ?? null;
	}

	/**
	* Returns all created parameters.
	*
	* @access 	public
	* @return 	Array
	*/
	public function getAll() : Array
	{
		return $this->parameters;
	}

	/**
	* Returns the number of parameters.
	*
	* @access 	public
	* @return 	Integer
	*/
	public function size() : Int
	{
		return sizeof(array_keys($this->getAll()));
	}

	/**
	* Return a parameter type.
	*
	* @param 	$paramter <Mixed>
	* @access 	public
	* @return 	Mixed
	*/
	public function getType($parameter='')
	{
		$parameterType = null;
		switch (gettype($parameter)) {
			case 'string':
				$parameterType = 's';
				break;
			case 'numeric':
			case 'integer':
				$parameterType = 'i';
				break;
			case 'double':
				$parameterType = 'd';
				break;
			default:
				$parameterType = null;
				break;
		}

		return $parameterType;
	}

}