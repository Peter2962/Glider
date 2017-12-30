<?php
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
	* @access 	public
	* @return 	Kit\Glider\Schema\Scheme
	*/
	public function varchar(String $name, int $length=15, Bool $null=false, Bool $autoIncrement=false, Array $options=[])
	{
		return $this->setType('Varchar', $name, $length, $null, $autoIncrement, $options);
	}

	/**
	* @access 	public
	* @return 	Kit\Glider\Schema\Scheme
	*/
	public function char(String $name, int $length=15, Bool $null=false, Bool $autoIncrement=false, Array $options=[])
	{
		return $this->setType('Char', $name, $length, $null, $autoIncrement, $options);
	}

	/**
	* @access 	public
	* @return 	Kit\Glider\Schema\Scheme
	*/
	public function integer(String $name, int $length=15, Bool $null=false, Bool $autoIncrement=false, Array $options=[])
	{
		return $this->setType('Integer', $name, $length, $null, $autoIncrement, $options);
	}

	/**
	* @access 	public
	* @return 	Kit\Glider\Schema\Scheme
	*/
	public function bit(String $name, int $length=15, Bool $null=false, Bool $autoIncrement=false, Array $options=[])
	{
		return $this->setType('Bit', $name, $length, $null, $autoIncrement, $options);
	}

	/**
	* @access 	public
	* @return 	Kit\Glider\Schema\Scheme
	*/
	public function tinyInt(String $name, int $length=15, Bool $null=false, Bool $autoIncrement=false, Array $options=[])
	{
		return $this->setType('TinyInt', $name, $length, $null, $autoIncrement, $options);
	}

	/**
	* @access 	public
	* @return 	Kit\Glider\Schema\Scheme
	*/
	public function smallInt(String $name, int $length=15, Bool $null=false, Bool $autoIncrement=false, Array $options=[])
	{
		return $this->setType('SmallInt', $name, $length, $null, $autoIncrement, $options);
	}

	/**
	* @access 	public
	* @return 	Kit\Glider\Schema\Scheme
	*/
	public function mediumInt(String $name, int $length=15, Bool $null=false, Bool $autoIncrement=false, Array $options=[])
	{
		return $this->setType('MediumInt', $name, $length, $null, $autoIncrement, $options);
	}

	/**
	* @access 	public
	* @return 	Kit\Glider\Schema\Scheme
	*/
	public function bigInt(String $name, int $length=15, Bool $null=false, Bool $autoIncrement=false, Array $options=[])
	{
		return $this->setType('BigInt', $name, $length, $null, $autoIncrement, $options);
	}

	/**
	* @access 	public
	* @return 	Kit\Glider\Schema\Scheme
	*/
	public function decimal(String $name, $length=15, Bool $null=false, Bool $autoIncrement=false, Array $options=[])
	{
		return $this->setType('Decimal', $name, $length, $null, $autoIncrement, $options);
	}

	/**
	* @access 	public
	* @return 	Kit\Glider\Schema\Scheme
	*/
	public function double(String $name, $length=15, Bool $null=false, Bool $autoIncrement=false, Array $options=[])
	{
		return $this->setType('Double', $name, $length, $null, $autoIncrement, $options);
	}

	/**
	* @access 	public
	* @return 	Kit\Glider\Schema\Scheme
	*/
	public function text(String $name, $length=15, Bool $null=false, Bool $autoIncrement=false, Array $options=[])
	{
		return $this->setType('Text', $name, $length, $null, $autoIncrement, $options);
	}

	/**
	* @access 	public
	* @return 	Kit\Glider\Schema\Scheme
	*/
	public function tinyText(String $name, $length=15, Bool $null=false, Bool $autoIncrement=false, Array $options=[])
	{
		return $this->setType('TinyText', $name, $length, $null, $autoIncrement, $options);
	}

	/**
	* @access 	public
	* @return 	Kit\Glider\Schema\Scheme
	*/
	public function mediumText(String $name, $length=15, Bool $null=false, Bool $autoIncrement=false, Array $options=[])
	{
		return $this->setType('MediumText', $name, $length, $null, $autoIncrement, $options);
	}

	/**
	* @access 	public
	* @return 	Kit\Glider\Schema\Scheme
	*/
	public function longText(String $name, $length=15, Bool $null=false, Bool $autoIncrement=false, Array $options=[])
	{
		return $this->setType('LongText', $name, $length, $null, $autoIncrement, $options);
	}

	/**
	* @access 	public
	* @return 	Kit\Glider\Schema\Scheme
	*/
	public function blob(String $name, $length=15, Bool $null=false, Bool $autoIncrement=false, Array $options=[])
	{
		return $this->setType('Blob', $name, $length, $null, $autoIncrement, $options);
	}

	/**
	* @access 	public
	* @return 	Kit\Glider\Schema\Scheme
	*/
	public function mediumBlob(String $name, $length=15, Bool $null=false, Bool $autoIncrement=false, Array $options=[])
	{
		return $this->setType('MediumBlob', $name, $length, $null, $autoIncrement, $options);
	}

	/**
	* @access 	public
	* @return 	Kit\Glider\Schema\Scheme
	*/
	public function longBlob(String $name, $length=15, Bool $null=false, Bool $autoIncrement=false, Array $options=[])
	{
		return $this->setType('LongBlob', $name, $length, $null, $autoIncrement, $options);
	}

	/**
	* @param 	$name <String>
	* @access 	public
	* @return 	Kit\Glider\Schema\Scheme
	*/
	public function index(String $name)
	{
		//
	}

	/**
	* @param 	$options <Array>
	* @access 	public
	* @return 	Kit\Glider\Schema\Scheme
	*/
	public function foreign(Array $options=[])
	{
		//
	}

	/**
	* Returns type sql definition.
	*
	* @access 	public
	* @return 	String
	*/
	public function getDefinition($separator=',')
	{
		$commands = self::$commands;

		return implode($separator, $commands);
	}

	/**
	* Returns array of columns created.
	*
	* @access 	public
	* @return 	Array
	* @static
	*/
	public static function getCommandsArray() : Array
	{
		return Scheme::$commandsArray;
	}

	/**
	* @param 	$type <String>
	* @param 	$name <String>
	* @param 	$length <Integer>
	* @param 	$null <Boolean>
	* @param 	$autoIncrement <Boolean>
	* @param 	$primary <Boolean>
	* @access 	protected
	* @return 	String
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
		$definition = $definition . $isNull . $isPrimary . $canAutoIncrement;

		Scheme::$commandsArray[$name] = $definition;
		Scheme::$commands[] = $definition;

		return $this;
	}

	/**
	* @param 	$type <String>
	* @access 	protected
	* @return 	String
	*/
	protected function getLength($definition, $length)
	{
		if ($length == null) {

			return $definition;

		}

		return $definition . '(' . $length . ')';
	}

}