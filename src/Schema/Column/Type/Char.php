<?php
namespace Kit\Glider\Schema\Column\Type;

use Kit\Glider\Schema\Column\Type\Contract\TypeContract;

class Char implements TypeContract
{

	/**
	* {@inheritDOc}
	*/
	public function getName() : String
	{
		return 'CHAR';
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
		return 500;
	}

	/**
	* {@inheritDOc}
	*/	
	public function getMaxTypeValueLength() : int
	{
		return 1;
	}

}