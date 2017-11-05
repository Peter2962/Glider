<?php
namespace Glider\Result\Exceptions;

use RuntimeException;

class InvalidPropertyAccessException extends RuntimeException
{

	/**
	* @param 	$property <String>
	* @access 	public
	* @return 	void
	*/
	public function __construct($property)
	{
		$message = $property . ' must be declared either private or protected.';
		parent::__construct($message);
	}

}