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

namespace Kit\Glider\Schema\Column\Contract;

// Represents a platform's column.

interface ColumnContract
{

	/**
	* Column constructor
	*
	* @param 	$column
	* @access 	public
	*/
	public function __construct($column);

	/**
	* Returns the column name.
	*
	* @access 	public
	* @return 	Mixed
	*/
	public function getName();

	/**
	* Returns the column type.
	*
	* @access 	public
	* @return 	Mixed
	*/
	public function getType();

	/**
	* Returns the column length.
	*
	* @access 	public
	* @return 	Mixed
	*/
	public function getLength();

	/**
	* Checks if column has default value.
	*
	* @access 	public
	* @return 	Boolean
	*/
	public function hasDefaultValue() : Bool;

	/**
	* Returns the column's default value.
	*
	* @access 	public
	* @return 	Mixed
	*/
	public function getDefaultValue();

	/**
	* Checks if a column is null.
	*
	* @access 	public
	* @return 	Boolean
	*/
	public function isNull() : Bool;

	/**
	* Checks if column has primary key index.
	*
	* @access 	public
	* @return 	Boolean
	*/
	public function isPrimary() : Bool;

	/**
	* Checks if column has unique index.
	*
	* @access 	public
	* @return 	Boolean
	*/
	public function isUnique() : Bool;

	/**
	* Checks if column has an index.
	*
	* @access 	public
	* @return 	Boolean
	*/
	public function hasIndex() : Bool;

	/**
	* Returns column's extra.
	*
	* @access 	public
	* @return 	Mixed
	*/
	public function getExtra();

}