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
* @package 	Kit\Glider\Statements\Contract\StatementContract
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