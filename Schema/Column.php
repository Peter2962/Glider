<?php
namespace Glider\Schema;

use Glider\Schema\Column\Type;

class Column
{

	/**
	* @var 		$column
	* @access 	protected
	*/
	protected 	$column;

	/**
	* @var 		$type
	* @access 	protected
	*/
	protected 	$type;

	/**
	* @var 		$length
	* @access 	protected
	*/
	protected 	$length;

	/**
	* @var 		$default
	* @access 	protected
	*/
	protected 	$default;

	/**
	* @var 		$extra
	* @access 	protected
	*/
	protected 	$extra;

	/**
	* @var 		$isNull
	* @access 	protected
	*/
	protected 	$isNull;

	/**
	* @var 		$isDefined
	* @access 	protected
	*/
	protected 	$isDefined = false;

	/**
	* @var 		$isPrimary
	* @access 	protected
	*/
	protected 	$isPrimary;

	/**
	* @param 	$name <String>
	* @access 	public
	* @return 	void
	*/
	public function __construct(String $name)
	{
		$this->column = $name;
	}

	/**
	* Sets column type.
	*
	* @param 	$type
	* @access 	public
	* @return 	Glider\Schema\Column
	*/
	public function setType($type) : Column
	{
		$this->type = $type;
		return $this;
	}

	/**
	* Set column as PRIMARY or not.
	*
	* @param 	$isPrimary <Boolean>
	* @access 	public
	* @return 	Glider\Schema\Column
	*/
	public function setPrimary(Bool $isPrimary=false) : Column
	{
		$this->isPrimary = $isPrimary;
		return $this;
	}

	/**
	* Sets column length.
	*
	* @param 	$length <Integer>
	* @access 	public
	* @return 	Glider\Schema\Column
	*/
	public function setLength(int $length) : Column
	{
		$this->length = $length;
		return $this;
	}

	/**
	* Sets column default value.
	*
	* @param 	$defaultValue <Mixed>
	* @access 	public
	* @return 	Glider\Schema\Column
	*/
	public function setDefaultValue($defaultValue=null) : Column
	{
		$this->default = $defaultValue;
		return $this;
	}

	/**
	* Auto increments column.
	*
	* @access 	public
	* @return 	Glider\Schema\Column
	*/
	public function setAutoIncrement()
	{

	}

	/**
	* Sets a column to null or not.
	*
	* @param 	$isNull <Boolean>
	* @access 	public
	* @return 	Glider\Schema\Column
	*/
	public function setIsNull(Bool $isNull=false)
	{
		$this->isNull = $isNull;
		return $this;
	}

	/**
	* Return column type.
	*
	* @access 	public
	* @return 	String
	*/
	public function getType()
	{
		return $this->type;
	}

	/**
	* Return column length.
	*
	* @access 	public
	* @return 	Integer
	*/
	public function getLength()
	{
		return $this->length;
	}

	/**
	* Return column default value.
	*
	* @access 	public
	* @return 	Mixed
	*/
	public function getDefaultValue()
	{
		return $this->defaultValue;
	}

	/**
	* Returns a column's sql definition.
	*
	* @access 	public
	* @return 	String
	*/
	public function toSql() : String
	{
		//
	}

	/**
	* Defines a column manually.
	*
	* @param 	$definition <String>
	* @access 	public
	* @return 	void
	*/
	public function defineColumn(String $definition)
	{
		//
	}

}