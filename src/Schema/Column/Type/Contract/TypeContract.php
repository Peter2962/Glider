<?php
namespace Kit\Glider\Schema\Column\Type\Contract;

interface TypeContract
{

	/**
	* Returns type name.
	*
	* @access 	public
	* @return 	String
	*/
	public function getName() : String;

	/**
	* Returns type minimum length.
	*
	* @access 	public
	* @return 	Integer
	*/
	public function getMinimumLength() : int;

	/**
	* Returns type maximum length.
	*
	* @access 	public
	* @return 	Integer
	*/
	public function getMaximumLength() : int;

	/**
	* Returns number of data type value if it is an array.
	*
	* @access 	public
	* @return 	Integer
	*/
	public function getMaxTypeValueLength() : int;

}