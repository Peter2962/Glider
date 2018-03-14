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
* @package 	Kit\Glider\Model\Foundation\Record
*/

namespace Kit\Glider\Model\Uses;

use Exception;
use Kit\Glider\Model\Model;


trait Record
{

	/**
	* Saves data into the model table in the database. This method also updates the data
	* if an id property is present. If an id is present, a check is made to see if a row
	* with the given id exists or not.
	* This method accepts an argument of $relatedModel. If a model is passed here, the related model
	* will be saved.
	*
	* @param 	$relatedModel <Object>
	* @access 	public
	* @return 	Object Kit\Glider\Model\Model
	*/
	public function save(Model $relatedModel=null) : Model
	{
		$savedModel = $this;
		$key = $this->primaryKey();

		if ($relatedModel instanceof Model) {

			// Does it have a relatedModel?

		}

		// If id property exists, update instead.
		if ($this->$key) {
			$this->update(
				$this->$key,
				$key,
				$this->getAssociatedTable(),
				$this->getSoftProperties()
			);

			return $savedModel;
		}

		$record = $this->queryBuilder()->insert(
			$this->getAssociatedTable(), // name of model table
			$this->getSoftProperties() // model soft properties
		);

		// assign new property $id amd add to soft properties
		$this->id = $record->insertId();

		return $savedModel;
	}

	/**
	* Deletes/removes a record from the database table.
	*
	* @access 	public
	* @return 	Object Kit\Glider\Model\Model
	*/
	public function delete() : Model
	{
		$builder = $this->queryBuilder();

		if (isset($this->softProperties[$this->key])) {
			$builder->where(
				$this->key, $this->softProperties[$this->key]
			);
		}

		$builder->delete($this->getAssociatedTable());

		return $this;
	}

	/**
	* Updates an existing record in the database table.
	*
	* @param 	$keyValue <Mixed>
	* @param 	$key <String>
	* @param 	$table <String>
	* @param 	$properties <Array>
	* @access 	protected
	* @return 	void
	*/
	protected function update($keyValue=null, String $key, String $table, Array $properties=[])
	{
		if (isset($properties[$key])) {
			unset($properties[$key]);
		}

		$this->queryBuilder()->where(
			$key, $keyValue
		)->update($table, $properties);

	}

}