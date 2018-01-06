<?php
namespace Kit\Glider\Schema\Column\Platform;

use StdClass;
use Kit\Glider\Schema\Column\Contract\ColumnContract;

class MysqliColumn implements ColumnContract
{

	/**
	* @var 		$column
	* @access 	protected
	*/
	protected 	$column;

	/**
	* {@inheritDoc}
	*/
	public function __construct($column)
	{
		$this->column = $column;
	}

	/**
	* {@inheritDoc}
	*/
	public function getName()
	{
		return $this->getAttribute('Field');
	}

	/**
	* {@inheritDoc}
	*/
	public function getType()
	{
		$type = $this->getAttribute('Type');

		if ($type !== null) {

			$type = preg_replace('/\(.*[0-9]\)/', '', $type);
		}

		return $type;
	}

	/**
	* {@inheritDoc}
	*/
	public function getLength()
	{
		$length = $type = $this->column->Type;

		if (preg_match("/\(.*[0-9]\)/", $type, $match)) {
		
			$match = $match[0];
		
			$length = str_replace(['(', ')'], '', $match);
		}

		return $length;
	}

	/**
	* {@inheritDoc}
	*/
	public function hasDefaultValue() : Bool
	{
		$attr = $this->getAttribute('Default');

		return ($attr == null) ? false: true;
	}

	/**
	* {@inheritDoc}
	*/
	public function getDefaultValue()
	{
		return $this->getAttribute('Default');
	}

	/**
	* {@inheritDoc}
	*/
	public function isNull() : Bool
	{
		$attr = $this->getAttribute('Null');

		return ($attr == 'YES') ? true : false;
	}

	/**
	* {@inheritDoc}
	*/
	public function hasIndex() : Bool
	{
		$attr = $this->getAttribute('Key');

		return ($attr == 'MUL') ? true : false;
	}

	/**
	* {@inheritDoc}
	*/
	public function isPrimary() : Bool
	{
		$attr = $this->getAttribute('Key');

		return ($attr == 'PRI') ? true : false;
	}

	/**
	* {@inheritDoc}
	*/
	public function isUnique() : Bool
	{
		$attr = $this->getAttribute('Key');

		return ($attr == 'UNI') ? true : false;
	}

	/**
	* {@inheritDoc}
	*/
	public function getExtra()
	{
		return $this->getAttribute('Extra');
	}

	/**
	* Resolve column object and return attribute.
	*
	* @param 	$attribute <String>
	* @access 	protected
	* @return 	Mixed
	*/
	protected function getAttribute(String $attribute)
	{
		if (!is_object($this->column)) {
			
			return null;

		}

		if (is_object($this->column) && isset($this->column->$attribute)) {

			return $this->column->$attribute;

		}

		if (is_array($this->column) && isset($this->column[$attribute])) {
			
			return $this->column[$attribute];

		}
	}

}