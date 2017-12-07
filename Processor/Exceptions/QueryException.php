<?php
namespace Glider\Processor\Exceptions;

use StdClass;
use Exception;

class QueryException extends Exception
{

	/**
	* This exception is thrown when/if an error occurs when a query
	* is run.
	*
	* @param 	$message <String>
	* @param 	$queryObject <StdClass>
	* @access 	public
	* @return 	void
	*/
	public function __construct(String $message, StdClass $queryObject)
	{
		$message .= ' [query: '. $queryObject->query .']';
		parent::__construct($message);
	}

}