<?php
namespace Glider\Query\Builder;

class QueryBinder
{

	/**
	* @var 		$bindings
	* @access 	protected
	* @static
	*/
	protected static $bindings = [];

	/**
	* @access 	public
	* @return 	void
	*/
	public function __construct()
	{
		QueryBinder::$bindings = [
			'select' => [],
			'join' => [],
			'innerjoin' => [],
			'outerjoin' => [],
			'rightOuterJoin' => [],
			'where' => [
				'parameters' => []
			]
		];
	}

	/**
	* This method bindings together queries created with
	* the query builder.
	*
	* @param 	$key <String>
	* @access 	public
	* @return 	void
	*/
	public function createBinding(String $key)
	{

	}

	/**
	*
	*
	*
	*/
	public function getBinding()
	{

	}

}