<?php
namespace Kit\Glider\Processor;

use Kit\Glider\Processor\Contract\ProcessorProvider;

abstract class AbstractProcessorProvider
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
	public static function setProcessorResult(ProcessorProvider $statementProvider)
	{
		//
	}

}