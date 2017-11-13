<?php
namespace Glider\Statements;

use Glider\Statements\Contract\StatementProvider;

abstract class AbstractStatementProvider
{

	/**
	* @param 	$property <String>
	* @param 	$value <Mixed>
	* @access 	public
	* @return 	void
	*/
	public function __set($property, $value)
	{
		//
	}

}