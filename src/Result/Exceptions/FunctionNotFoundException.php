<?php
namespace Kit\Glider\Result\Exceptions;

use Exception;

class FunctionNotFoundException extends Exception
{

	/**
	* @param 	$$message <String>
	* @access 	public
	* @return 	void
	*/
	public function __construct(String $message=null)
	{
		parent::__construct($message);
	}

}