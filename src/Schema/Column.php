<?php
namespace Kit\Glider\Schema;

use RuntimeException;
use Kit\Glider\Schema\Column\Type;

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
	* @param 	$column <String>
	* @access 	public
	* @return 	void
	*/
	public function __construct($column)
	{
		$this->column = $column;
	}

	/**
	* Sets column type.
	*
	* @param 	$type
	* @access 	public
	* @return 	Kit\Glider\Schema\Column
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
	* @return 	Kit\Glider\Schema\Column
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
	* @return 	Kit\Glider\Schema\Column
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
	* @return 	Kit\Glider\Schema\Column
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
	* @return 	Kit\Glider\Schema\Column
	*/
	public function setAutoIncrement()
	{
		//
	}

	/**
	* Sets a column to null or not.
	*
	* @param 	$isNull <Boolean>
	* @access 	public
	* @return 	Kit\Glider\Schema\Column
	*/
	public function setIsNull(Bool $isNull=false)
	{
		$this->isNull = $isNull;
		return $this;
	}

	/**
	* Return column name.
	*
	* @access 	public
	* @return 	String
	*/
	public function getName()
	{
		return $this->column->Field;
	}

	/**
	* Return column type.
	*
	* @access 	public
	* @return 	String
	*/
	public function getType($withLength=true)
	{
		$type = $this->column->Type;

		$type = preg_replace('/\(.*[0-9]\)/', '', $type);

		return $type;
	}

	/**
	* Return column length.
	*
	* @access 	public
	* @return 	Integer
	*/
	public function getLength()
	{
		$type = $this->column->Type;

		if (preg_match("/\(.*[0-9]\)/", $type, $match)) {
			$match = $match[0];
			return str_replace(['(', ')'], '', $match);
		}

		return null;
	}

	/**
	* Return column default value.
	*
	* @access 	public
	* @return 	Mixed
	*/
	public function getDefault()
	{
		return $this->column->Default;
	}

	/**
	* @access 	public
	* @return 	Boolean
	*/
	public function isNull() : Bool
	{
		return $this->column->NULL == 'NO' ? false : true;
	}

	/**
	* Returns a column's sql definition.
	*
	* @access 	public
	* @return 	String
	*/
	public function toSql() : String
	{
		$column = '';
		if (!is_string($this->column)) {
			throw new RuntimeException('Cannot convert column object to string.');
		}

		return $column;
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

	/**
	* Set column attribute.
	*
	* @param 	$attribute <String>
	* @param 	$value <Mixed>
	* @access 	protected
	* @return 	void
	*/
	protected function setAttribute(String $attribute, $value)
	{
		//
	}

	/**
	* Return column attribute.
	*
	* @param 	$attribute <String>
	* @access 	protected
	* @return 	Mixed
	*/
	protected function getAttribute(String $attribute)
	{
		//
	}

}