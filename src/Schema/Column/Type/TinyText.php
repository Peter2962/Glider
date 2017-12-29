<?php
namespace Kit\Glider\Schema\Column\Type;

use Kit\Glider\Schema\Column\Type\Contract\TypeContract;

class TinyText implements TypeContract
{

	/**
	* {@inheritDOc}
	*/
	public function getName() : String
	{
		return 'TINYTEXT';
	}

	/**
	* {@inheritDOc}
	*/
	public function getMinimumLength() : int
	{
		return 0;
	}

	/**
	* {@inheritDOc}
	*/
	public function getMaximumLength() : int
	{
		return 0;
	}

	/**
	* {@inheritDOc}
	*/	
	public function getMaxTypeValueLength() : int
	{
		return 1;
	}

}