<?php
/**
* @package 	ResultMapper
* @version 	0.1.0
*
* ResultMapper helps to define properties that would be accessed in a result set.
* All ResultMapper classes must extend this class.
* The properties access can be either public/protected/private. But making it private
* is more recommended.
*
*/

namespace Glider\Result;

use ReflectionClass;
use ReflectionProperty;
use Glider\Result\Contract\ResultMapperContract;
use Glider\Result\Exceptions\InvalidPropertyAccessException;

abstract Class ResultMapper implements ResultMapperContract
{

	/**
	* @access 	public
	* @return 	void
	*/
	public function register() : Bool
	{
		return $this->register();
	}

	/**
	* This class maps a field in the result set to a property of the ResultMapper
	* class provided.
	*
	* @param 	$field <String>
	* @param 	$value <Mixed>
	* @access 	public
	* @return 	void
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
	* Check if a property is not public.
	*
	* @param 	$property <Object>
	* @access 	private
	* @return 	Boolean
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