<?php
namespace Glider\Statements;

use Glider\Statements\Contract\StatementProvider;

abstract class AbstractStatementProvider
{

	/**
	* @var 		$statementResult
	* @access 	protected
	* @static
	*/
	protected static $statementResult;

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

	/**
	* Set the statement result from a processed query.
	*
	* @param 	$statementProvider
	* @access 	public
	* @return 	Object
	*/
	public static function setStatementResult(StatementProvider $statementProvider)
	{
		AbstractStatementProvider::$statementResult = $statementProvider->getStatement();
	}

}