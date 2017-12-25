<?php
namespace Glider\Schema\Column\Type;

use Glider\Schema\Column\Type\Contract\TypeContract;

class BaseType implements TypeContract
{

	/**
	* @var 		$name
	* @access 	protected
	*/
	protected 	$name;

	/**
	* @var 		$length
	* @access 	protected
	*/
	protected 	$length;

	/**
	* {@inheritDoc}
	*/
	public function __construct(String $name)
	{
		$this->name = $name;
	}

	/**
	* @param 	$methodName <String>
	* @param 	$arguments <Array>
	* @access 	public
	* @return 	Mixed
	*/
	public function __call($methodName, $arguments)
	{
		
	}

	/**
	* {@inheritDoc}
	*/
	public function setLength(int $length) : TypeContract
	{
		$this->length = $length;
		return $this;
	}

}