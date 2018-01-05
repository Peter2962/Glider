<?php
namespace Kit\Glider\Schema\Column\Index;

use StdClass;
use Kit\Glider\Schema\Column\Index\Contract\IndexContract;

class MysqliIndex implements IndexContract
{

	/**
	* @var 		$index
	* @access 	protected
	*/
	protected 	$index;

	/**
	* {@inheritDoc}
	*/
	public function __construct(StdClass $index)
	{
		$this->index = $index;
	}

	/**
	* {@inheritDoc}
	*/
	public function getTable() : String
	{
		return $this->index->Table;
	}

	/**
	* {@inheritDoc}
	*/
	public function getName() : String
	{
		return $this->index->Key_name;
	}

	/**
	* {@inheritDoc}
	*/
	public function getSequence() : int
	{
		return $this->index->Seq_in_index;
	}

	/**
	* {@inheritDoc}
	*/
	public function isUnique() : Bool
	{
		return ($this->index->Non_unique == 0) ? true : false;
	}

	/**
	* {@inheritDoc}
	*/
	public function isNull() : Bool
	{
		return (strtolower($this->index->Null) == 'yes') ? true : false;
	}

	/**
	* {@inheritDoc}
	*/
	public function getColumnName() : String
	{
		return $this->index->Column_name;
	}
}