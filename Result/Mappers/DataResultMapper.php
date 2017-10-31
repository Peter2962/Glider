<?php
namespace Glider\Result\Mappers;

use Glider\Result\ResultMapper;
use Glider\Result\Contract\ResultMapperContract;

class DataResultMapper extends ResultMapper
{

	/**
	* @var 		$id
	* @access 	public
	*/
	public 		$id;

	/**
	* @var 		$name
	* @access 	public
	*/
	public 		$name;

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
	public function getActiveMapping()
	{

	}

}