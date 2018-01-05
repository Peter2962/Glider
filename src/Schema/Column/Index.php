<?php
namespace Kit\Glider\Schema\Column;

class Index
{

	/**
	* @var 		$index
	* @access 	protected
	*/
	protected 	$index;

	/**
	* Constructs an index
	*
	* @param 	$index <Object>
	* @access 	public
	* @return 	void
	*/
	public function __construct(StdClass $index)
	{
		$this->index = $index;
	}

	/**
	* Returns the table where the index is.
	*
	* @access 	public
	* @return 	String
	*/
	public function getTable()
	{

	}

	/**
	* @access 	protected
	* @return 	String
	*/
	protected function setDefinition()
	{

	}

}