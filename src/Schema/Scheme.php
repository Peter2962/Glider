<?php
/**
* @author 		Peter Taiwo <peter@phoxphp.com>
* @package 		Kit\Glider\Schema\Scheme
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

namespace Kit\Glider\Schema;

use RuntimeException;
use Kit\Glider\Schema\Column\ColumnTypeCache;
use Kit\Glider\Schema\Column\Type\Contract\TypeContract;

class Scheme
{

	/**
	* @var 		$column
	* @access 	protected
	* @static
	*/
	protected static $column;

	/**
	* @var 		$length
	* @access 	protected
	* @static
	*/
	protected static $length;

	/**
	* @var 		$null
	* @access 	protected
	* @static
	*/
	protected static $null;

	/**
	* @var 		$primary
	* @access 	protected
	* @static
	*/
	protected static $primary;

	/**
	* @var 		$commands
	* @access 	protected
	* @static
	*/
	protected static $commands;

	/**
	* @var 		$commandsArray
	* @access 	protected
	* @static
	*/
	protected static $commandsArray = [];

	/**
	* @var 		$indexes
	* @access 	protected
	*/
	protected 	$indexes = ['default' => 'INDEX', 'unique' => 'UNIQUE INDEX'];

	/**
	* @var 		$typeNamespace
	* @access 	protected
	*/
	protected 	$typeNamespace = 'Kit\Glider\Schema\Column\Type';

	/**
	* @var 		$definition
	* @access 	protected
	*/
	protected	$definition;

	/**
	* @const 	SET_UNIQUE_KEY 
	*/
	const 		SET_UNIQUE_KEY = 1;

	/**
	* Represents an auto incremented field with a primary key index.
	*
	* @param 	$name String
	* @param 	$length Integer
	* @param 	$null Boolean
	* @access 	public
	* @return 	Object Kit\Glider\Schema\Column\Type\Contract\TypeContract
	*/
	public function id(String $name = 'id', int $length = 15, Bool $null = false)
	{
		return $this->integer($name, $length, $null, true, ['primary' => true]);
	}

	/**
	* Represents a variable-length non-binary string field.
	*
	* @param 	$name String
	* @param 	$length Integer
	* @param 	$null Boolean
	* @param 	$autoIncrement Boolean
	* @param 	$options Array
	* @access 	public
	* @return 	Object Kit\Glider\Schema\Column\Type\Contract\TypeContract
	*/
	public function varchar(String $name, int $length=15, Bool $null=false, Bool $autoIncrement=false, Array $options=[])
	{
		return $this->setType('Varchar', $name, $length, $null, $autoIncrement, $options);
	}

	/**
	* Represents a fixed-length nonbinary (character) string field.
	*
	* @param 	$name String
	* @param 	$length Integer
	* @param 	$null Boolean
	* @param 	$autoIncrement Boolean
	* @param 	$options Array
	* @access 	public
	* @return 	Object Kit\Glider\Schema\Column\Type\Contract\TypeContract
	*/
	public function char(String $name, int $length=15, Bool $null=false, Bool $autoIncrement=false, Array $options=[])
	{
		return $this->setType('Char', $name, $length, $null, $autoIncrement, $options);
	}

	/**
	* Represents a standard integer field.
	*
	* @param 	$name String
	* @param 	$length Integer
	* @param 	$null Boolean
	* @param 	$autoIncrement Boolean
	* @param 	$options Array
	* @access 	public
	* @return 	Object Kit\Glider\Schema\Column\Type\Contract\TypeContract
	*/
	public function integer(String $name, int $length=15, Bool $null=false, Bool $autoIncrement=false, Array $options=[])
	{
		return $this->setType('Integer', $name, $length, $null, $autoIncrement, $options);
	}

	/**
	* Represents a bit field.
	*
	* @param 	$name String
	* @param 	$length Integer
	* @param 	$null Boolean
	* @param 	$autoIncrement Boolean
	* @param 	$options Array
	* @access 	public
	* @return 	Object Kit\Glider\Schema\Column\Type\Contract\TypeContract
	*/
	public function bit(String $name, int $length=15, Bool $null=false, Bool $autoIncrement=false, Array $options=[])
	{
		return $this->setType('Bit', $name, $length, $null, $autoIncrement, $options);
	}

	/**
	* Represents a very small integer field.
	*
	* @param 	$name String
	* @param 	$length Integer
	* @param 	$null Boolean
	* @param 	$autoIncrement Boolean
	* @param 	$options Array
	* @access 	public
	* @return 	Object Kit\Glider\Schema\Column\Type\Contract\TypeContract
	*/
	public function tinyInt(String $name, int $length=15, Bool $null=false, Bool $autoIncrement=false, Array $options=[])
	{
		return $this->setType('TinyInt', $name, $length, $null, $autoIncrement, $options);
	}

	/**
	* Represents a small integer field.
	*
	* @param 	$name String
	* @param 	$length Integer
	* @param 	$null Boolean
	* @param 	$autoIncrement Boolean
	* @param 	$options Array
	* @access 	public
	* @return 	Object Kit\Glider\Schema\Column\Type\Contract\TypeContract
	*/
	public function smallInt(String $name, int $length=15, Bool $null=false, Bool $autoIncrement=false, Array $options=[])
	{
		return $this->setType('SmallInt', $name, $length, $null, $autoIncrement, $options);
	}

	/**
	* Represents a medium-sized integer field. 
	*
	* @param 	$name String
	* @param 	$length Integer
	* @param 	$null Boolean
	* @param 	$autoIncrement Boolean
	* @param 	$options Array
	* @access 	public
	* @return 	Object Kit\Glider\Schema\Column\Type\Contract\TypeContract
	*/
	public function mediumInt(String $name, int $length=15, Bool $null=false, Bool $autoIncrement=false, Array $options=[])
	{
		return $this->setType('MediumInt', $name, $length, $null, $autoIncrement, $options);
	}

	/**
	* Represents a large integer field.
	*
	* @param 	$name String
	* @param 	$length Integer
	* @param 	$null Boolean
	* @param 	$autoIncrement Boolean
	* @param 	$options Array
	* @access 	public
	* @return 	Object Kit\Glider\Schema\Column\Type\Contract\TypeContract
	*/
	public function bigInt(String $name, int $length=15, Bool $null=false, Bool $autoIncrement=false, Array $options=[])
	{
		return $this->setType('BigInt', $name, $length, $null, $autoIncrement, $options);
	}

	/**
	* Represents a fixed-point number field.
	*
	* @param 	$name String
	* @param 	$length Integer
	* @param 	$null Boolean
	* @param 	$autoIncrement Boolean
	* @param 	$options Array
	* @access 	public
	* @return 	Object Kit\Glider\Schema\Column\Type\Contract\TypeContract
	*/
	public function decimal(String $name, $length=15, Bool $null=false, Bool $autoIncrement=false, Array $options=[])
	{
		return $this->setType('Decimal', $name, $length, $null, $autoIncrement, $options);
	}

	/**
	* Represents a double-precision floating number field.
	*
	* @param 	$name String
	* @param 	$length Integer
	* @param 	$null Boolean
	* @param 	$autoIncrement Boolean
	* @param 	$options Array
	* @access 	public
	* @return 	Object Kit\Glider\Schema\Column\Type\Contract\TypeContract
	*/
	public function double(String $name, $length=15, Bool $null=false, Bool $autoIncrement=false, Array $options=[])
	{
		return $this->setType('Double', $name, $length, $null, $autoIncrement, $options);
	}

	/**
	* Represents a small non-binary string field. 
	*
	* @param 	$name String
	* @param 	$length Integer
	* @param 	$null Boolean
	* @param 	$autoIncrement Boolean
	* @param 	$options Array
	* @access 	public
	* @return 	Object Kit\Glider\Schema\Column\Type\Contract\TypeContract
	*/
	public function text(String $name, $length=15, Bool $null=false, Bool $autoIncrement=false, Array $options=[])
	{
		return $this->setType('Text', $name, $length, $null, $autoIncrement, $options);
	}

	/**
	* Represents a very small non-binary string field. 
	*
	* @param 	$name String
	* @param 	$length Integer
	* @param 	$null Boolean
	* @param 	$autoIncrement Boolean
	* @param 	$options Array
	* @access 	public
	* @return 	Object Kit\Glider\Schema\Column\Type\Contract\TypeContract
	*/
	public function tinyText(String $name, $length=15, Bool $null=false, Bool $autoIncrement=false, Array $options=[])
	{
		return $this->setType('TinyText', $name, $length, $null, $autoIncrement, $options);
	}

	/**
	* Represents a medium sized non-binary string field. 
	*
	* @param 	$name String
	* @param 	$length Integer
	* @param 	$null Boolean
	* @param 	$autoIncrement Boolean
	* @param 	$options Array
	* @access 	public
	* @return 	Object Kit\Glider\Schema\Column\Type\Contract\TypeContract
	*/
	public function mediumText(String $name, $length=15, Bool $null=false, Bool $autoIncrement=false, Array $options=[])
	{
		return $this->setType('MediumText', $name, $length, $null, $autoIncrement, $options);
	}

	/**
	* Represents a large non-binary string field. 
	*
	* @param 	$name String
	* @param 	$length Integer
	* @param 	$null Boolean
	* @param 	$autoIncrement Boolean
	* @param 	$options Array
	* @access 	public
	* @return 	Object Kit\Glider\Schema\Column\Type\Contract\TypeContract
	*/
	public function longText(String $name, $length=15, Bool $null=false, Bool $autoIncrement=false, Array $options=[])
	{
		return $this->setType('LongText', $name, $length, $null, $autoIncrement, $options);
	}

	/**
	* Represents a small blob field. 
	*
	* @param 	$name String
	* @param 	$length Integer
	* @param 	$null Boolean
	* @param 	$autoIncrement Boolean
	* @param 	$options Array
	* @access 	public
	* @return 	Object Kit\Glider\Schema\Column\Type\Contract\TypeContract
	*/
	public function blob(String $name, $length=15, Bool $null=false, Bool $autoIncrement=false, Array $options=[])
	{
		return $this->setType('Blob', $name, $length, $null, $autoIncrement, $options);
	}

	/**
	* Represents a medium-sized blob field. 
	*
	* @param 	$name String
	* @param 	$length Integer
	* @param 	$null Boolean
	* @param 	$autoIncrement Boolean
	* @param 	$options Array
	* @access 	public
	* @return 	Object Kit\Glider\Schema\Column\Type\Contract\TypeContract
	*/
	public function mediumBlob(String $name, $length=15, Bool $null=false, Bool $autoIncrement=false, Array $options=[])
	{
		return $this->setType('MediumBlob', $name, $length, $null, $autoIncrement, $options);
	}

	/**
	* Represents a large blob field. 
	*
	* @param 	$name String
	* @param 	$length Integer
	* @param 	$null Boolean
	* @param 	$autoIncrement Boolean
	* @param 	$options Array
	* @access 	public
	* @return 	Object Kit\Glider\Schema\Column\Type\Contract\TypeContract
	*/
	public function longBlob(String $name, $length=15, Bool $null=false, Bool $autoIncrement=false, Array $options=[])
	{
		return $this->setType('LongBlob', $name, $length, $null, $autoIncrement, $options);
	}

	/**
	* Represents a date field. 
	*
	* @param 	$name String
	* @param 	$null Boolean
	* @param 	$options Array
	* @access 	public
	* @return 	Object Kit\Glider\Schema\Column\Type\Contract\TypeContract
	* @since 	1.4.6
	*/
	public function date(String $name, Bool $null = false, Array $options = [])
	{
		return $this->setType('Date', $name, null, $null, false, $options);
	}

	/**
	* Represents a date_created timestamp field.
	*
	* @access 	public
	* @return 	Object Kit\Glider\Schema\Column\Type\Contract\TypeContract
	* @since 	1.4.6
	*/
	public function dateCreated()
	{
		return $this->date('date_created', true);
	}

	/**
	* Represents a date_updated timestamp field.
	*
	* @access 	public
	* @return 	Object Kit\Glider\Schema\Column\Type\Contract\TypeContract
	* @since 	1.4.6
	*/
	public function dateUpdated()
	{
		return $this->timestamp('date_updated', true);
	}

	/**
	* Represents a time field. 
	*
	* @param 	$name String
	* @param 	$null Boolean
	* @param 	$options Array
	* @access 	public
	* @return 	Object Kit\Glider\Schema\Column\Type\Contract\TypeContract
	* @since 	1.4.6
	*/
	public function time(String $name, Bool $null = false, Array $options = [])
	{
		return $this->setType('Time', $name, null, $null, false, $options);
	}

	/**
	* Represents a datetime field. 
	*
	* @param 	$name String
	* @param 	$null Boolean
	* @param 	$options Array
	* @access 	public
	* @return 	Object Kit\Glider\Schema\Column\Type\Contract\TypeContract
	* @since 	1.4.6
	*/
	public function datetime(String $name, Bool $null = false, Array $options = [])
	{
		return $this->setType('DateTime', $name, null, $null, false, $options);
	}

	/**
	* Represents a year field. 
	*
	* @param 	$name String
	* @param 	$null Boolean
	* @param 	$options Array
	* @access 	public
	* @return 	Object Kit\Glider\Schema\Column\Type\Contract\TypeContract
	* @since 	1.4.6
	*/
	public function year(String $name, Bool $null = false, Array $options = [])
	{
		return $this->setType('Year', $name, null, $null, false, $options);
	}

	/**
	* Represents a timestamp field. 
	*
	* @param 	$name String
	* @param 	$null Boolean
	* @param 	$options Array
	* @access 	public
	* @return 	Object Kit\Glider\Schema\Column\Type\Contract\TypeContract
	* @since 	1.4.6
	*/
	public function timestamp(String $name, Bool $null = false, Array $options = [])
	{
		return $this->setType('Timestamp', $name, null, $null, false, $options);
	}

	/**
	* @param 	$name <String>
	* @param 	$columns <Array>
	* @param 	$setUnique <Integer>
	* @access 	public
	* @return 	<Object> <Kit\Glider\Schema\Scheme>
	*/
	public function index(String $name, Array $columns=[], int $setUnique=0)
	{
		$index = 'INDEX ' . $name . '(' . implode(',', $columns) . ')';
		$type = 'INDEX';

		if ($setUnique == Scheme::SET_UNIQUE_KEY) {

			$index = 'UNIQUE ' . $index;
			$type = 'UNIQUE_INDEX';

		}

		Scheme::$commandsArray[$name] = ['type' => $type, 'definition' => $index];
		Scheme::$commands[] = $index;

		return $this;
	}

	/**
	* Generates a foreign key constraint.
	*
	* @param 	$keyName <String>
	* @param 	$options <Array>
	* @param 	$onDelete <String>
	* @param 	$onUpdate <String>
	* @access 	public
	* @return 	<void>
	*/
	public function foreign(String $keyName, Array $options=[], String $onDelete='NO ACTION', String $onUpdate='NO ACTION')
	{
		$columns = $options['columns'];
		$referenceTable = $options['references'];
		$refColumns = $options['refColumns'];

		$clauseList = ['CASCADE', 'RESTRICT', 'NO ACTION'];

		if (is_array($columns)) {
			$columns = implode(',', $columns);
		}

		if (is_array($refColumns)) {
			$refColumns = implode(',', $refColumns);
		}

		$onDelete = strtoupper($onDelete);
		$onUpdate = strtoupper($onUpdate);

		if (!in_array($onDelete, $clauseList)) {
			$onDelete = $clauseList[2];
		}

		if (!in_array($onUpdate, $clauseList)) {
			$onUpdate = $clauseList[2];
		}	

		$definition = 'FOREIGN KEY ' . $keyName . '(' . $columns . ') REFERENCES ' . $referenceTable . '(' . $refColumns . ')';
		$definition .= ' ON UPDATE ' . $onUpdate . ' ON DELETE ' . $onDelete;

		$options['type'] = 'FOREIGN';
		$options['definition'] = $definition;

		Scheme::$commandsArray[$keyName] = $options;
		Scheme::$commands[] = $definition;
	}

	/**
	* Returns type sql definition.
	*
	* @access 	public
	* @return 	<Mixed>
	*/
	public function getDefinition($separator=',')
	{
		$commands = self::$commands;

		if (sizeof($commands) > 0) {
			return implode($separator, $commands);
		}

		return null;
	}

	/**
	* Returns array of columns created.
	*
	* @access 	public
	* @return 	<Array>
	* @static
	*/
	public static function getCommandsArray() : Array
	{
		return Scheme::$commandsArray;
	}

	/**
	* Sets the given column/field type.
	*
	* @param 	$type <String>
	* @param 	$name <String>
	* @param 	$length <Integer>
	* @param 	$null <Boolean>
	* @param 	$autoIncrement <Boolean>
	* @param 	$primary <Boolean>
	* @access 	protected
	* @return 	<String>
	*/
	protected function setType(String $type, String $name, $length, Bool $null, Bool $autoIncrement, Array $options)
	{
		$definition = $name;
		
		$isNull = ' NOT NULL';
		$canAutoIncrement = ' AUTO_INCREMENT';

		$isPrimary =  (isset($options['primary']) && $options['primary'] == true) ? ' PRIMARY KEY' : '';
		$index = '';

		$type = ucfirst($type);

		if (!class_exists($this->typeNamespace . '\\' . $type)) {
			throw new RuntimeException(sprintf('Class for type %s does not exist.', $type));
		}

		$type = $this->typeNamespace . '\\' . $type;
		$typeClass = new $type();
		$dataType = $typeClass->getName();

		$diffTypes = ['DECIMAL', 'DOUBLE', 'TEXT', 'LONGTEXT', 'MEDIUMTEXT', 'LONGTEXT', 'FOREIGN'];

		if ($length < $typeClass->getMinimumLength() || $length > $typeClass->getMaximumLength() && !in_array($dataType, $diffTypes)) {
			throw new RuntimeException(sprintf('Invalid length for column %s', $name));
		}

		if (is_array($length)) {
			$length = implode(',', $length);
		}

		if ($null == true) {
			$isNull = ' NULL';
		}

		if ($autoIncrement == false) {
			$canAutoIncrement = '';
		}

		$definition = $name . ' ' . $typeClass->getName();
		$definition = $this->getLength($definition, $length);
		
		if (isset($options['unsigned']) && $options['unsigned'] == true) {
			$definition .= ' UNSIGNED';
		}

		$definition .= $isNull . $isPrimary . $canAutoIncrement;

		if (isset($options['default'])) {
			$definition .= ' DEFAULT ' . $options['default'];
		}

		Scheme::$commandsArray[$name] = ['type' => $dataType, 'definition' => $definition];
		Scheme::$commands[] = $definition;

		return $this;
	}

	/**
	* Empties the columns and columnsArray property.
	*
	* @access 	public
	* @return 	<void>
	* @static
	*/
	public static function destroyColumns()
	{
		Scheme::$commands = [];
		Scheme::$commandsArray = [];
	}

	/**
	* @param 	$type <String>
	* @access 	protected
	* @return 	<String>
	*/
	protected function getLength($definition, $length)
	{
		if ($length == null) {
			return $definition;
		}

		return $definition . '(' . $length . ')';
	}

}