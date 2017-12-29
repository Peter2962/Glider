<?php
namespace Kit\Glider\Query\Exceptions;

use Exception;

class ParameterNotFoundException extends Exception
{

	/**
	* @param 	$message <String>
	* @access 	public
	* @return 	void
	*/
	public function __construct(String $message)
	{
		parent::__construct($message);
	}

}