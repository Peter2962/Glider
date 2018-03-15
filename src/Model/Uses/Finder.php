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
* @package 	Kit\Glider\Model\Uses\Finder
*/

namespace Kit\Glider\Model\Uses;

use Exception;
use Kit\Glider\Model\Model;
use Kit\Glider\Model\Attributes;
use Kit\Glider\Model\Collection;

trait Finder
{

	/**
	* Handles findBy methods called via __callStatic magic method. If the result returned is more than
	* one, an array of the model object is returned.
	*
	* @param 	$context <Kit\Glider\Model\Model>
	* @param 	$childModel <Kit\Glider\Model\Model>
	* @param 	$childClassName <String>
	* @param 	$clause <String>
	* @param 	$clauseArguments <Array>
	* @access 	protected
	* @return 	Mixed
	*/
	protected function initializeFindBy(Model $context, Model $childModel, String $childClassName, String $clause, Array $clauseArguments=[])
	{
		$this->table = $childModel->table;
		$builder = $this->toSql(
			$this->getAccessibleProperties(
				[Attributes::ALL_SELECTOR],
				false
			)
		)->whereIn(
			$clause, $clauseArguments
		)->get();

		if ($builder->first()) {

			// If the result is not empty, the accessible properties will be extracted and returned.
			$accessibleProperties = $childModel->accessibleProperties();
			$resultArray = $builder->toArray()->all();

			if (count($resultArray) > 1) {
				$results = [];

				foreach($resultArray as $i => $result) {
					$res = $resultArray[$i];

					// If '$childModel' property is used here, same records will be returned so we are
					// to create new instances of the model class.
					$accessible = new $childClassName;

					foreach(array_keys($res) as $i => $key) {
						if ($childModel->isAccessible($key)) {
							$accessible->softProperties[$key] = $res[$key];
						}
					}

					$results[] = $accessible;
					$accessible = null;
				}

				return new Collection($results, $childModel);
			}else{
				foreach($resultArray[0] as $key => $result) {
					if ($childModel->isAccessible($key)) {
						$childModel->softProperties[$key] = $resultArray[0][$key];
					}
				}
			}
		}

		return $childModel;
	}

}