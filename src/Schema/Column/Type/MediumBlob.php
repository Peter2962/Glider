<?php
namespace Kit\Glider\Schema\Column\Type;

use Kit\Glider\Schema\Column\Type\Contract\TypeContract;

class MediumBlob implements TypeContract
{

	/**
	* {@inheritDOc}
	*/
	public function getName() : String
	{
		return 'MEDIUMBLOB';
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