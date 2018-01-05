<?php
namespace Kit\Glider\Schema\Column\Index\Contract;

use StdClass;

interface IndexContract
{

	/**
	* COnstructor.
	*
	* @param 	$index <Object>
	* @access 	public
	* @return 	void
	*/
	public function __construct(StdClass $index);

	/**
	* Returns the table where the index is found.
	*
	* @access 	public
	* @return 	String
	*/
	public function getTable() : String;

	/**
	* Returns name of index.
	*
	* @access 	public
	* @return 	String
	*/
	public function getName() : String;

	/**
	* Returns the index sequence.
	*
	* @access 	public
	* @return 	Integer
	*/
	public function getSequence() : int;

	/**
	* Checks if index is unique or not.
	*
	* @access 	public
	* @return 	Boolean
	*/
	public function isUnique() : Bool;

	/**
	* Checks if index is null.
	*
	* @access 	public
	* @return 	Boolean
	*/
	public function isNull() : Bool;

	/**
	* Returns the index column.
	*
	* @access 	public
	* @return 	String
	*/
	public function getColumnName() : String;

}