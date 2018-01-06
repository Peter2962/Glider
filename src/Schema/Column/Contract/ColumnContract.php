<?php
namespace Kit\Glider\Schema\Column\Contract;

// Represents a platform's column.

interface ColumnContract
{

	/**
	* Column constructor
	*
	* @param 	$column
	* @access 	public
	*/
	public function __construct($column);

	/**
	* Returns the column name.
	*
	* @access 	public
	* @return 	Mixed
	*/
	public function getName();

	/**
	* Returns the column type.
	*
	* @access 	public
	* @return 	Mixed
	*/
	public function getType();

	/**
	* Returns the column length.
	*
	* @access 	public
	* @return 	Mixed
	*/
	public function getLength();

	/**
	* Checks if column has default value.
	*
	* @access 	public
	* @return 	Boolean
	*/
	public function hasDefaultValue() : Bool;

	/**
	* Returns the column's default value.
	*
	* @access 	public
	* @return 	Mixed
	*/
	public function getDefaultValue();

	/**
	* Checks if a column is null.
	*
	* @access 	public
	* @return 	Boolean
	*/
	public function isNull() : Bool;

	/**
	* Checks if column has primary key index.
	*
	* @access 	public
	* @return 	Boolean
	*/
	public function isPrimary() : Bool;

	/**
	* Checks if column has unique index.
	*
	* @access 	public
	* @return 	Boolean
	*/
	public function isUnique() : Bool;

	/**
	* Checks if column has an index.
	*
	* @access 	public
	* @return 	Boolean
	*/
	public function hasIndex() : Bool;

	/**
	* Returns column's extra.
	*
	* @access 	public
	* @return 	Mixed
	*/
	public function getExtra();

}