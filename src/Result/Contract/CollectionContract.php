<?php
/**
* MIT License
* Permission is hereby granted, free of charge, to any person obtaining a copy
* of this software and associated documentation files (the "Software"), to deal
* in the Software without restriction, including without limitation the rights
* to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
* copies of the Software, and to permit persons to whom the Software is
* furnished to do so, subject to the following conditions:

* The above copyright notice and this permission notice shall be included in all
* copies or substantial portions of the Software.

* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
* IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
* FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
* AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
* LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
* OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
* SOFTWARE.
*/

/**
* @author 	Peter Taiwo
* @package 	Kit\Glider\Result\Contract\CollectionContract
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

namespace Kit\Glider\Result\Contract;

use Closure;
use Kit\Glider\Statements\Contract\StatementProvider;

interface CollectionContract
{

	/**
	* Collection instance constructor.
	*
	* @param 	$statementProvider Kit\Glider\Statements\Contract\StatementProvider | Array
	* @param 	$statement <Mixed>
	* @access 	public
	* @return 	void
	*/
	public function __construct($statementProvider, $statement);

	/**
	* Return a property from statement.
	*
	* @param 	$property <String>
	* @access 	public
	* @return 	Mixed
	*/
	public function __get($property);

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
	* @return 	Kit\Glider\Resets\CollectionContract
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
	* This method returns an instance of Kit\Glider\Result\Collection if the collected
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
	* @return 	Kit\Glider\Result\CollectionContract
	*/
	public function add($data) : CollectionContract;

	/**
	* Remove data from the collection only if it exists.
	* This method removes data by the array index or offset. To remove a data
	* using a custom key, @see Collection::removeWhere.
	*
	* @param 	$key <Mixed>
	* @access 	public
	* @return 	Kit\Glider\Result\CollectionContract
	*/
	public function remove($key) : CollectionContract;

	/**
	* Remove data from collection using custom key.
	*
	* @param 	$key <String>
	* @param 	$value <Mixed>
	* @access 	public
	* @return 	Kit\Glider\Result\CollectionContract
	*/
	public function removeWhere(String $key, $value) : CollectionContract;

	/**
	* Iterate over list of elements and calls a callback function on
	* each iterated element.
	*
	* @param 	$elements <Array>
	* @param 	$callback <Closure>
	* @param 	$with <Array>
	* @access 	public
	* @return 	Kit\Glider\Result\CollectionContract
	*/
	public function map(Array $elements, Closure $callback, Array $with=[]) : CollectionContract;

	/**
	* Convert an object or flattens objects to array.
	* Because thos method returns CollectionContract, to get the
	* converted list, COllectionContract::all() should be used.
	*
	* @param 	$elements <Array>
	* @access 	public
	* @return 	Kit\Glider\Result\CollectionContract
	* @see 		Kit\Glider\Result\CollectionContract::all
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
	* @return 	Kit\Glider\Result\CollectionContract
	*/
	public function invoke(Array $elements, String $functionName) : CollectionContract;

	/**
	* Returns the maximum value in the list. This method returns the maximum value
	* using the index by default or. If the list is a multidimensional array, the index
	* that will be used to get the maximum should be passed as the second parameter value.
	* The first parameter can either be an array or an instance of Kit\Glider\Result\CollectionContract.
	*
	* @param 	$elements <Mixed> Array|Kit\Glider\Result\CollectionContract
	* @param 	$index <String>
	* @access 	public
	* @return 	Mixed
	*/
	public function max($elements=[], String $index=null);

	/**
	* Returns the minimum value in the list. This method returns the minimum value
	* using the index by default or. If the list is a multidimensional array, the index
	* that will be used to get the minimum should be passed as the second parameter value.
	* The first parameter can either be an array or an instance of Kit\Glider\Result\CollectionContract.
	*
	* @param 	$elements <Mixed> Array|Kit\Glider\Result\CollectionContract
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
	* @return 	Kit\Glider\Result\CollectionContract
	* @see 		Kit\Glider\Result\CollectionContract::all
	*/
	public function groupBy(String $key) : CollectionContract;

	/**
	* Partitions or splits collection into number provided as parameter.
	*
	* @param 	$to <Integer>
	* @access 	public
	* @return 	Kit\Glider\Result\CollectionContract
	* @see 		Kit\Glider\Result\CollectionContract::all
	*/
	public function partition(int $to) : CollectionContract;

	/**
	* Loops through the collection and returns the array of elements that contains the
	* key-value pairs provided in the @param $conditions parameter.
	*
	* @param 	$conditions <Array>
	* @access 	public
	* @return 	Kit\Glider\Result\CollectionContract
	*/
	public function where(Array $conditions=[]) : CollectionContract;

}