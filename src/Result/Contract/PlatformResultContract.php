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
* @package 	Kit\Glider\Result\Contract\PlatformResultContract
*/

namespace Kit\Glider\Result\Contract;

interface PlatformResultContract
{

	/**
	* Returns number of rows in a result set.
	*
	* @access 	public
	* @return 	Integer
	*/
	public function numRows();

	/**
	* Returns an array containing the lengths of every
	* column of the current row within the result set.
	*
	* @access 	public
	* @return 	Integer
	*/
	public function lengths();

	/**
	* Returns number of fields in a result set.
	*
	* @access 	public
	* @return 	Integer
	*/
	public function fieldCount();

	/**
	* Returns all rows as an array. If using Mysqli Platform, mysql native driver
	* must be installed to make this work. If not, an error will be returned. 
	*
	* @access 	public
	* @return 	Integer
	*/
	public function fetchAll();

	/**
	* Returns result set as an associative array.
	*
	* @access 	public
	* @return 	Integer
	*/
	public function fetchArray();

	/**
	* Returns result set as an object.
	*
	* @access 	public
	* @return 	Integer
	*/
	public function fetchObject();

}