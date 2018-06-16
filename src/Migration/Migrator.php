<?php
/**
* @author 		Peter Taiwo <peter@phoxphp.com>
* @package 		Kit\Glider\Migration\Migrator
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

namespace Kit\Glider\Migration;

use Closure;
use Kit\Glider\Helper;
use Kit\Glider\Repository;
use Kit\Glider\Migration\Model;
use Kit\Glider\Migration\Attribute;
use Kit\Glider\Schema\SchemaManager;
use Kit\Glider\Console\Command\Migration;
use Kit\Glider\Migration\Exceptions\MigrationClassNotFoundException;

class Migrator
{

	/**
	* Creates 'migrations' table if it does not exist.
	*
	* @access 	public
	* @return 	<void>
	*/
	public function createMigrationsTable()
	{
		SchemaManager::table('migrations')->create(function($scheme) {
			$scheme->integer('id', 11, false, true, ['primary' => true]);
			$scheme->varchar('class_name', 255, false);
			$scheme->varchar('status', 25, false);
			$scheme->varchar('path', 255, false);
		});
	}

	/**
	* Returns migration files from migrations directory.
	*
	* @param 	$directory <String>
	* @access 	protected
	* @return 	<Array>
	*/
	protected function getMigrationFilesFromDirectory(String $directory) : Array
	{
		$files = [];
		$tableMigrationsClassFile = $directory . '/' . Migration::DEFAULT_MIGRATION_FILENAME . '.php';

		foreach(glob($directory . '/*' . '.php') as $file) {
			if ($file !== $tableMigrationsClassFile) {
				$files[] = $file;
			}
		}

		return $files;
	}

	/**
	* Runs all migration classes in migrations directory.
	*
	* @param 	$migrationsDirectory <String>
	* @access 	public
	* @return 	<void>
	*/
	public function runMigrations(String $migrationsDirectory)
	{
		
		$migrationFiles = $this->getMigrationFilesFromDirectory($migrationsDirectory);
		$migrations = Model::where('status', 'pending');

		if ($migrations->get()->size() > 0) {
			foreach($migrations->get()->all() as $migration) {
				require_once $migration->path;

				$this->runSingleMigration($migration);
			}
		}
	}

	/**
	* Runs a specific migration class.
	*
	* @param 	$migration <Object>
	* @access 	public
	* @return 	<void>
	*/
	public function runSingleMigration($migration)
	{

		$migrationClass = $migration->class_name;
		if (!class_exists($migrationClass)) {
			throw new MigrationClassNotFoundException(
				sprintf(
					'Migration class [%s] does not exist',
					$migrationClass
				)
			);
		}

		$class = new $migrationClass();

		if (Migration::migrationType() == Attribute::DOWNGRADE) {
			$class->down();
		}else{
			$class->up();
		}

		$migration = Model::findById($migration->id);
		$migration->status = 'migrated';
		$migration->save();
	}

}