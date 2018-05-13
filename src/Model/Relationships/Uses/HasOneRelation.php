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
* @package 	Kit\Glider\Model\Relationships\HasOneRelation
*/

namespace Kit\Glider\Model\Relationships\Uses;

use ReflectionMethod;
use Kit\Glider\Model\Model;
use Kit\Glider\Query\Builder\QueryBuilder;

class HasOneRelation
{

	/**
	* @var 		$parentModel
	* @access 	public
	*/
	public 		$parentModel;

	/**
	* @var 		$related
	* @access 	public
	*/
	public 		$related = null;

	/**
	* @var 		$keys
	* @access 	public
	*/
	public		$keys = [];

	/**
	* @var 		$builder
	* @access 	protected
	*/
	protected 	$builder;

	/**
	* Constructor
	*
	* @param 	$builder <Kit\Glider\Query\Builder\QueryBuilder>
	* @access 	public
	* @return 	void
	*/
	public function __construct(QueryBuilder $builder)
	{
		$this->builder = $builder;
	}

	/**
	* @param 	$property <String>
	* @param 	$value <Mixed>
	* @access 	public
	* @return 	Mixed
	*/
	public function __set($property, $value)
	{
		//
	}

	/**
	* @param 	$method <String>
	* @param 	$arguments <Array>
	* @access 	public
	* @return 	Mixed
	*/
	public function __call($method, $arguments)
	{
		$reflectionMethod = new ReflectionMethod(
			get_class($this->related),
			$method
		);

		// Invoke related model method calls
		return $reflectionMethod->invokeArgs(
			$this->related,
			$arguments
		);
	}

	/**
	* @param 	$property <String>
	* @access 	public
	* @return 	Mixed
	*/
	public function __get($property)
	{
		// Only return property if related model is not null
		if ($this->related instanceof Model) {
			return $this->related->$property;
		}

		return null;
	}

}