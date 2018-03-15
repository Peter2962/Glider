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
* @package 	Kit\Glider\Model\Collection
*/

namespace Kit\Glider\Model;

use Kit\Glider\Model\Model;
use Kit\Glider\Result\Collection as BaseCollection;

class Collection extends BaseCollection
{

	/**
	* @var 		$context
	* @access 	protected
	*/
	protected 	$context;

	/**
	* @param 	$collected <Array>
	* @param 	$context <Mixed>
	* @access 	public
	*/
	public function __construct($collected=null, $context=null)
	{
		$this->context = $context;
		parent::__construct($collected);
	}

	/**
	* This method returns the model associated to the result being collected.
	* This method is not available if just a row is being returned from the result set.
	* If called, an error will be thrown.
	*
	* Usage:
	* 
	* $page = Page::findById(6, 7);
	* $page->getContext();
	*
	* @access 	public
	* @return 	Object Kit\Glider\Model\Model
	*/
	public function getContext() : Model
	{
		return $this->context;
	}

}