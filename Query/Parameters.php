<?php
/**
* This class helps to set and get query parameters.
*/

namespace Glider\Query;

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

}