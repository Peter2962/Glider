<?php
/**
* @author 		Peter Taiwo <peter@phoxphp.com>
* @package 		Kit\Glider\Model\Uses\Record
* @license 		MIT License
*
* Permission is hereby granted, free of charge, to any person obtaining a copy
* of this software and associated documentation files (the "Software"), to deal
* in the Software without restriction, including without limitation the rights
* to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
* copies of the Software, and to permit persons to whom the Software is
* furnished to do so, subject to the following conditions:
*
* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
* IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
* FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
* AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
* LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
* OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
* SOFTWARE.
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
	* @return 	<Object> <Kit\Glider\Model\Model>
	*/
	public function save(Model $relatedModel=null) : Model
	{
		$currentModel = $this;
		$key = $currentModel->primaryKey();

		if ($relatedModel instanceof Model) {

			// Does it have a relatedModel? If no error is thrown till we get here,
			// then the relationship was successfully initialized.
			$parentModelForeignKey = $this->relationKeys['parent_model_foreign_key'];
			$parentModelKeyValue = $this->relationKeys['parent_model_foreign_key_value'];

			$currentModel = $relatedModel;
			$currentModel->$parentModelForeignKey = $parentModelKeyValue;
			$key = $currentModel->primaryKey();

		}

		// If id property exists, update instead.
		if ($currentModel->$key) {
			$currentModel->update(
				$currentModel->$key,
				$key,
				$currentModel->getAssociatedTable(),
				$currentModel->getSoftProperties()
			);

			return $currentModel;
		}

		$record = $currentModel->queryBuilder()->insert(
			$currentModel->getAssociatedTable(), // name of model table
			$currentModel->getSoftProperties() // model soft properties
		);

		// assign new property $id amd add to soft properties
		$currentModel->id = $record->insertId();

		return $currentModel;
	}

	/**
	* Deletes/removes a record from the database table.
	*
	* @access 	public
	* @return 	<Object> <Kit\Glider\Model\Model>
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
	* @return 	<void>
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