<?php
/**
* @author 	Peter Taiwo
* @package 	Glider\Result\Contract\CollectionContract
*
* Methods:
* 1. __construct
* 2. all - Return array of query result.
* 3. first - Return the first element of query result array.
* 4. next - Return the next element of query result array.
* 5. offset - Return the query result at a specific offset.
* 6. only - Return the query result at a specific offset.
*/

namespace Glider\Result\Contract;

use Glider\Statements\Contract\StatementProvider;

interface CollectionContract
{

	/**
	* Collection instance constructor.
	*
	* @param 	$statementProvider Glider\Statements\Contract\StatementProvider
	* @param 	$statement <Mixed>
	* @access 	public
	* @return 	void
	*/
	public function __construct(StatementProvider $statementProvider, $statement);

	/**
	* Returns an array of query result.
	*
	* @access 	public
	* @return 	Array
	*/
	public function all() : Array;

	/**
	* Return the first offset of the query result array.
	*
	* @access 	public
	* @return 	Mixed
	*/
	public function first();

	/**
	* Return the next offset of the query result array.
	*
	* @access 	public
	* @return 	Mixed
	*/
	public function next();

	/**
	* Return the query result at a specific offset.
	*
	* @param 	$offset <Integer>
	* @access 	public
	* @return 	Mixed
	*/
	public function offset(int $offset=0);

	/**
	* @param 	$columns <Array>
	* @access 	public
	* @return 	Mixed
	*/
	public function only(...$columns);

}