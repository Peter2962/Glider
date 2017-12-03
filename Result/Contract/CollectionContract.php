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
* 7. size - Return size of collected array result.
* 8. add - Append data to the collection.
* 9. remove - Remove data from the collection only if it exists.
* 10. removeWhere - Remove data from the collection only if it exists.
*/

namespace Glider\Result\Contract;

use Closure;
use Glider\Statements\Contract\StatementProvider;

interface CollectionContract
{

	/**
	* Collection instance constructor.
	*
	* @param 	$statementProvider Glider\Statements\Contract\StatementProvider | Array
	* @param 	$statement <Mixed>
	* @access 	public
	* @return 	void
	*/
	public function __construct($statementProvider, $statement);

	/**
	* Return result statement.
	*
	* @access 	public
	* @return 	Mixed
	*/
	public function statement();

	/**
	* Resets the saved collection.
	*
	* @access 	public
	* @return 	Glider\Resets\CollectionContract
	*/
	public function reset() : CollectionContract;

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
	* Return only specific or certain columns from a query result set.
	* This method returns an instance of Glider\Result\Collection if the collected
	* result is not empty.
	* Usage: $result->only('id', 'name');
	*
	* @param 	$columns <Array>
	* @access 	public
	* @return 	Mixed
	*/
	public function only(...$columns);

	/**
	* Return size of collected array result.
	*
	* @access 	public
	* @return 	Integer
	*/
	public function size() : int;

	/**
	* Append data to the collection.
	*
	* @param 	$data <Mixed>
	* @access 	public
	* @return 	Glider\Result\CollectionContract
	*/
	public function add($data) : CollectionContract;

	/**
	* Remove data from the collection only if it exists.
	* This method removes data by the array index or offset. To remove a data
	* using a custom key, @see Collection::removeWhere.
	*
	* @param 	$key <Mixed>
	* @access 	public
	* @return 	Glider\Result\CollectionContract
	*/
	public function remove($key) : CollectionContract;

	/**
	* Remove data from collection using custom key.
	*
	* @param 	$key <String>
	* @param 	$value <Mixed>
	* @access 	public
	* @return 	Glider\Result\CollectionContract
	*/
	public function removeWhere(String $key, $value) : CollectionContract;

	/**
	* Iterate over list of elements and calls a callback function on
	* each iterated element.
	*
	* @param 	$elements <Array>
	* @param 	$callback <Closure>
	* @access 	public
	* @return 	Glider\Result\CollectionContract
	*/
	public function map(Array $elements, Closure $callback) : CollectionContract;

	/**
	* Convert an object or flattens objects to array.
	* Because thos method returns CollectionContract, to get the
	* converted list, COllectionContract::all() should be used.
	*
	* @param 	$elements <Array>
	* @access 	public
	* @return 	Glider\Result\CollectionContract
	* @see 		Glider\Result\CollectionContract::all
	*/
	public function toArray(Array $elements=[]) : CollectionContract;

	/**
	* Invokes each element of the array with a custom function.
	* If the function does not exist, a FunctionNotFoundException is thrown.
	* The function's first two parameters will be the iterated element and it's index.
	* Basic Usage: function test($element, $index) {}
	*
	* @param 	$elements <Array>
	* @param 	$functionName <String>
	* @access 	public
	* @return 	Glider\Result\CollectionContract
	*/
	public function invoke(Array $elements, String $functionName) : CollectionContract;

	/**
	* Returns the maximum value in the list. This method returns the maximum value
	* using the index by default or. If the list is a multidimensional array, the index
	* that will be used to get the maximum should be passed as the second parameter value.
	* The first parameter can either be an array or an instance of Glider\Result\CollectionContract.
	*
	* @param 	$elements <Mixed> Array|Glider\Result\CollectionContract
	* @param 	$index <String>
	* @access 	public
	* @return 	Mixed
	*/
	public function max($elements=[], String $index=null);

	/**
	* Returns the minimum value in the list. This method returns the minimum value
	* using the index by default or. If the list is a multidimensional array, the index
	* that will be used to get the minimum should be passed as the second parameter value.
	* The first parameter can either be an array or an instance of Glider\Result\CollectionContract.
	*
	* @param 	$elements <Mixed> Array|Glider\Result\CollectionContract
	* @param 	$index <String>
	* @access 	public
	* @return 	Mixed
	*/
	public function min($elements=[], String $index=null);

	/**
	* Iterates over the array list and group each iterated element by
	* the key provided as the parameter @param $key. This method assumes
	* that the key has unique values.
	* To get grouped list, use CollectionContract::all. 
	*
	* @param 	$key <String>
	* @access 	public
	* @return 	Glider\Result\CollectionContract
	* @see 		Glider\Result\CollectionContract::all
	*/
	public function groupBy(String $key) : CollectionContract;

	/**
	* Partitions or splits collection into number provided as parameter.
	*
	* @param 	$to <Integer>
	* @access 	public
	* @return 	Glider\Result\CollectionContract
	* @see 		Glider\Result\CollectionContract::all
	*/
	public function partition(int $to) : CollectionContract;

	/**
	* Loops through the collection and returns the array of elements that contains the
	* key-value pairs provided in the @param $conditions parameter.
	*
	* @param 	$conditions <Array>
	* @access 	public
	* @return 	Glider\Result\CollectionContract
	*/
	public function where(Array $conditions=[]) : CollectionContract;

}