<?php
/**
* @author 		Peter Taiwo <peter@phoxphp.com>
* @package 		Kit\Glider\Result\ResultMapper
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

namespace Kit\Glider\Result;

use ReflectionClass;
use ReflectionProperty;
use Kit\Glider\Result\Contract\ResultMapperContract;
use Kit\Glider\Result\Exceptions\InvalidPropertyAccessException;

abstract Class ResultMapper implements ResultMapperContract
{

	/**
	* {@inheritDoc}
	*/
	public function register() : Bool
	{
		return $this->register();
	}

	/**
	* Maps a field in the result set to a property of the ResultMapper
	* class provided.
	*
	* @param 	$field <String>
	* @param 	$value <Mixed>
	* @access 	public
	* @return 	<void>
	*/
	public function mapFieldToClassProperty(String $field, $value)
	{
		$subClass = get_called_class();
		$reflection = new ReflectionClass($subClass);

		$properties = $reflection->getProperties();
		$property = new ReflectionProperty($this, $field);

		if ($property->isPublic()) {
			// If the property is not either protected or private, we need to return an error
			// because it is recommended that all properties are either protected or private.
			throw new InvalidPropertyAccessException($property->getName());
		}

		// Make property accessible and assign value to it.
		$property->setAccessible(true);
		$property->setValue($this, $value);
	}

	/**
	* Returns name of mapper class.
	*
	* @access 	public
	* @return 	<String>
	*/
	abstract public function getMapperName() : String;

	/**
	* Check if a property is not public.
	*
	* @param 	$property <Object>
	* @access 	private
	* @return 	<Boolean>
	*/
	private function isLockedProperty(ReflectionProperty $property) : Bool
	{
		$locked = false;
		if (!$property->isPublic()) {
			$locked = true;
		}

		return $locked;
	}

}