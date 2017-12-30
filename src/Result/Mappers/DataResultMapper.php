<?php
namespace Kit\Glider\Result\Mappers;

use Kit\Glider\Result\ResultMapper;
use Kit\Glider\Result\Contract\ResultMapperContract;

class DataResultMapper extends ResultMapper
{

	/**
	* @var 		$id
	* @access 	protected
	*/
	protected 		$id;

	/**
	* @var 		$name
	* @access 	protected
	*/
	protected 		$name;

	/**
	* {@inheritDoc}
	*/
	public function register() : Bool
	{
		return true;
	}

	/**
	* {@inheritDoc}
	*/
	public function getName()
	{
		return $this->name;
	}

}