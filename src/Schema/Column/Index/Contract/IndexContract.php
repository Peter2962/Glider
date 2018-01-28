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

namespace Kit\Glider\Schema\Column\Index\Contract;

use StdClass;

interface IndexContract
{

	/**
	* COnstructor.
	*
	* @param 	$index <Object>
	* @access 	public
	* @return 	void
	*/
	public function __construct(StdClass $index);

	/**
	* Returns the table where the index is found.
	*
	* @access 	public
	* @return 	String
	*/
	public function getTable() : String;

	/**
	* Returns name of index.
	*
	* @access 	public
	* @return 	String
	*/
	public function getName() : String;

	/**
	* Returns the index sequence.
	*
	* @access 	public
	* @return 	Integer
	*/
	public function getSequence() : int;

	/**
	* Checks if index is unique or not.
	*
	* @access 	public
	* @return 	Boolean
	*/
	public function isUnique() : Bool;

	/**
	* Checks if index is null.
	*
	* @access 	public
	* @return 	Boolean
	*/
	public function isNull() : Bool;

	/**
	* Returns the index column.
	*
	* @access 	public
	* @return 	String
	*/
	public function getColumnName() : String;

}