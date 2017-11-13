<?php
namespace Glider\Result\Mappers;

use Glider\Result\ResultMapper;
use Glider\Result\Contract\ResultMapperContract;

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