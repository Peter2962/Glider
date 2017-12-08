<?php
namespace Glider\Result\Platforms;

use mysqli_result;
use Glider\Result\Contract\PlatformResultContract;

class MysqliResult implements PlatformResultContract
{

	/**
	* @var 		$result
	* @access 	protected
	*/
	protected 	$result;

	/**
	* @param 	$result mysqli_result
	* @access 	public
	* @return 	void
	*/
	public function __construct(mysqli_result $result)
	{
		$this->result = $result;
	}

	/**
	* {@inheritDoc}
	*/
	public function numRows() : int
	{
		return $this->result->num_rows;
	}

	/**
	* {@inheritDoc}
	*/
	public function lengths() : int
	{
		return $this->result->lengths;
	}

	/**
	* {@inheritDoc}
	*/
	public function fieldCount() : int
	{
		return $this->result->field_count;
	}

	/**
	* {@inheritDoc}
	*/
	public function fetchArray()
	{

	}

	/**
	* {@inheritDoc}
	*/
	public function fetchObject()
	{

	}

	/**
	* {@inheritDoc}
	*/
	public function fetchAll()
	{

	}

}