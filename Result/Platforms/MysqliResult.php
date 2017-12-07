<?php
namespace Glider\Result\Platforms;

use mysqli_result;

class MysqliResult
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
	* @access 	public
	* @return 	Integer
	*/
	public function numRows() : int
	{
		return $this->result->num_rows;
	}

	/**
	* @access 	public
	* @return 	Integer
	*/
	public function lengths() : int
	{
		return $this->result->lengths;
	}

	/**
	* @access 	public
	* @return 	Integer
	*/
	public function fieldCount() : int
	{
		return $this->result->field_count;
	}

	/**
	* @access 	public
	* @return 	Mixed
	*/
	public function currentField()
	{
		return $this->result->current_field;
	}

}