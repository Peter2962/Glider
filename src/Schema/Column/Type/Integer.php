<?php
namespace Kit\Glider\Schema\Column\Type;

use Kit\Glider\Schema\Column\Type\Contract\TypeContract;

class Integer implements TypeContract
{

	/**
	* {@inheritDOc}
	*/
	public function getName() : String
	{
		return 'INT';
	}

	/**
	* {@inheritDOc}
	*/
	public function getMinimumLength() : int
	{
		return 1;
	}

	/**
	* {@inheritDOc}
	*/
	public function getMaximumLength() : int
	{
		return 255;
	}

	/**
	* {@inheritDOc}
	*/	
	public function getMaxTypeValueLength() : int
	{
		return 1;
	}

}