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
* @package 	Kit\Glider\Model\Relatioships\HasMany
*/

namespace Kit\Glider\Model\Relationships;

use RuntimeException;
use Kit\Glider\Repository;
use Kit\Glider\Model\Model;
use Kit\Glider\Schema\Table;
use Kit\Glider\Model\Collection;
use Kit\Glider\Model\Relationships\Uses\HasManyRelation;

trait HasMany
{

	/**
	* Processes a hasmany relationship type.
	*
	* @param 	$options <Array> [Required]
	* 			The $options array must have the following keys set:
	* --------------------------------------------------------------
	* - related_model - Related model class.
	* - related_model_label - Related model class label.
	* - related_model_table - Name of related model table.
	* - model_foreign_key - Model foreign key that is available on the related model table.
	* - model_key - Model primary key.
	*
	* @access 	public
	* @return 	Object <Kit\Glider\Model\Relationships\Uses\HasManyRelation>
	*/
	public function hasMany(Array $options) : HasManyRelation
	{
		$options = (Object) $options;

		$relatedModelName = $options->related_model;
		$relatedModelTable = $options->related_model_table;
		$modelForeignKey = $options->model_foreign_key;
		$modelKey = $options->model_key;
		$modelTable = $this->table;

		// Add this related model to array of relations
		$this->relations[] = [
			'model' => $relatedModelName,
			'foreign_key' => $modelForeignKey,
			'key' => $modelKey
		];

		// Set connection id to avoid connection id errors.
		Repository::setGlobalConnectionId($this->connectionId);
		$table = new Table($relatedModelTable);

		// Check if related model has the relation column.
		if (!$table->hasColumn($modelForeignKey)) {
			throw new RuntimeException(
				sprintf(
					'Column `%s` does not exist in `%s` table',
					$modelForeignKey,
					$relatedModelTable
				)
			);
		}

		$table = null;
		$relatedModel = new $relatedModelName();

		// set criteria
		$keyValue = $this->$modelKey;
		$criteria = 'findBy' . $modelForeignKey;
		$relatedModelObject = $relatedModelName::$criteria($keyValue);
		$hasManyRelation = new HasManyRelation($this->queryBuilder());

		// // Assign parent model
		$hasManyRelation->parentModel = $this;

		if ($relatedModelObject->getContext() instanceof Model) {
			$relatedModelObject->getContext()->relationKeys = [
				'parent_model_primary' => $modelKey,
				'parent_model_foreign_key' => $modelForeignKey,
				'parent_model_foreign_key_value' => $this->$modelKey
			];
		}

		$hasManyRelation->related = $relatedModelObject;
		return $hasManyRelation;
	}

}