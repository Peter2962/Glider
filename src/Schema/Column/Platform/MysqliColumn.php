<?php
/**
* @author 		Peter Taiwo <peter@phoxphp.com>
* @package 		Kit\Glider\Schema\Column\Platform\MysqliColumn
* @license 		MIT License
*
* Permission is hereby granted, free of charge, to any person obtaining a copy
* of this software and associated documentation files (the "Software"), to deal
* in the Software without restriction, including without limitation the rights
* to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
* copies of the Software, and to permit persons to whom the Software is
* furnished to do so, subject to the following conditions:
*
* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
* IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
* FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
* AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
* LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
* OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
* SOFTWARE.
*/

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
	* @return 	<Mixed>
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