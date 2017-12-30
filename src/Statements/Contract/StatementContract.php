<?php
/**
* @package 	Kit\Glider\Statements\Contract\StatementContract
* @version 	0.1.0
*
* StatementContract helps to formulize a platform's statement. It gives
* each platform an architecture template that is required. The StatementProvider handles
* query processing. 
* @method affectedRows
* @method errno
* @method errorList
* @method error
* @method fieldCount
* @method insertId
* @method paramCount
* @method sqlState
*/

namespace Kit\Glider\Statements\Contract;

use mysqli_stmt;
use Kit\Glider\Query\Parameters;
use Kit\Glider\Result\Collection;
use Kit\Glider\Query\Builder\QueryBuilder;
use Kit\Glider\Query\Builder\SqlGenerator;
use Kit\Glider\Platform\Contract\PlatformProvider;

interface StatementContract
{
	/**
	* @access 	public
	* @return 	Integer
	*/
	public function affectedRows() : int;

	/**
	* Return error number.
	*
	* @access 	public
	* @return 	Integer
	*/
	public function errno() : int;

	/**
	* Return an array of error list.
	*
	* @access 	public
	* @return 	Integer
	*/
	public function errorList();

	/**
	* Returns error string.
	*
	* @access 	public
	* @return 	Integer
	*/
	public function error();

	/**
	* @access 	public
	* @return 	Integer
	*/
	public function fieldCount() : int;

	/**
	* Returns the last insert id.
	*
	* @access 	public
	* @return 	Integer
	*/
	public function insertId();

	/**
	* Returns size of parameters.
	*
	* @access 	public
	* @return 	Integer
	*/
	public function paramCount() : int;

	/**
	* Returns sql state.
	*
	* @access 	public
	* @return 	Integer
	*/
	public function sqlState() : int;
}