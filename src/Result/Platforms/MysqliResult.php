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
	* @param 	$result <Mixed>
	* @access 	public
	* @return 	void
	*/
	public function __construct($result)
	{
		$this->result = $result;
	}

	/**
	* {@inheritDoc}
	*/
	public function numRows() : int
	{
		return $this->_get('num_rows');
	}

	/**
	* {@inheritDoc}
	*/
	public function lengths() : int
	{
		return $this->_get('lengths');
	}

	/**
	* {@inheritDoc}
	*/
	public function fieldCount() : int
	{
		return $this->_get('field_count');
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
		return $this->_get('fetch_object', false);
	}

	/**
	* {@inheritDoc}
	*/
	public function fetchAll()
	{
		return $this->_get('fetch_all', false);
	}

	/**
	* @param 	$key <String>
	* @param 	$isProperty <Boolean>
	* @access 	protected
	* @return 	Mixed
	*/
	protected function _get(String $key, Bool $isProperty=true)
	{
		if ($this->result instanceof mysqli_result) {
			if ($isProperty == false) {
				return $this->result->$key();
			}

			return $this->result->$key;
		}

		return false;
	}

}