<?php
namespace Glider\Result\Contract;

interface PlatformResultContract
{

	/**
	* Returns number of rows in a result set.
	*
	* @access 	public
	* @return 	Integer
	*/
	public function numRows();

	/**
	* Returns an array containing the lengths of every
	* column of the current row within the result set.
	*
	* @access 	public
	* @return 	Integer
	*/
	public function lengths();

	/**
	* Returns number of fields in a result set.
	*
	* @access 	public
	* @return 	Integer
	*/
	public function fieldCount();

	/**
	* Returns all rows as an array. If using Mysqli Platform, mysql native driver
	* must be installed to make this work. If not, an error will be returned. 
	*
	* @access 	public
	* @return 	Integer
	*/
	public function fetchAll();

	/**
	* Returns result set as an associative array.
	*
	* @access 	public
	* @return 	Integer
	*/
	public function fetchArray();

	/**
	* Returns result set as an object.
	*
	* @access 	public
	* @return 	Integer
	*/
	public function fetchObject();

}