<?php
/**
* @author 		Peter Taiwo <peter@phoxphp.com>
* @package 		Kit\Glider\Console\Command\Migration
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

namespace Kit\Glider\Console\Command;

use Kit\Glider\Helper;
use Kit\Console\Command;
use Kit\Console\Environment;
use Kit\Glider\Migration\Model;
use Kit\Console\Contract\Runnable;
use Kit\Glider\Migration\Migrator;
use Kit\Glider\Migration\Attribute;
use Kit\Glider\Console\TemplateBuilder;
use Kit\Glider\Migration\Exceptions\MigrationFileInvalidException;

class Migration implements Runnable
{
	
	/**
	* @var 		$env
	* @access 	protected
	*/
	protected	$env;

	/**
	* @var 		$cmd
	* @access 	protected
	*/
	protected	$cmd;

	/**
	* @var 		$migrationType
	* @access 	protected
	* @static
	*/
	protected static $migrationType = 'UP';

	/**
	* @constant DEFAULT_MIGRATION_FILENAME
	*/
	const 		DEFAULT_MIGRATION_FILENAME = 'create_migrations_table';

	/**
	* @var 		$migrator
	* @access 	protected
	*/
	protected 	$migrator;

	/**
	* {@inheritDoc}
	*/
	public function __construct(Environment $env, Command $cmd)
	{
		$this->env = $env;
		$this->cmd = $cmd;
		$this->migrator = new Migrator();
	}

	/**
	* {@inheritDoc}
	*/
	public function getId() : String
	{
		return 'migration';
	}

	/**
	* {@inheritDoc}
	*/
	public function run(Array $argumentsList, int $argumentsCount)
	{
		switch ($argumentsList[0]) {
			case 'create':
				return $this->create();
				break;
			case 'run':
				return $this->processMigrations();
				break;
			default:
				# code...
				break;
		}
	}

	/**
	* {@inheritDoc}
	*/
	public function runnableCommands() : Array
	{
		return [
			'create' => ':none',
			'run' => ':none',
			'run-class' => 1
		];
	}

	/**
	* Returns either 'UP' or 'DOWN'.
	*
	* @access 	public
	* @return 	<String>
	* @static
	*/
	public static function migrationType()
	{
		return self::$migrationType;
	}

	/**
	* Creates a migration.
	*
	* @param 	$arguments <Array>
	* @access 	protected
	* @return 	<void>
	*/
	protected function create(Array $arguments=[])
	{
		// The migrations table will only be created if it does not exist already.
		$this->migrator->createMigrationsTable();

		$migrationsDirectory = $this->cmd->getConfigOpt('migrations_storage');
		$templateTags = [];

		$migrationName = $this->cmd->question('Migration filename?');
		$filename = trim($migrationName);

		$path = $migrationsDirectory . '/' . $filename . '.php';

		if (file_exists($path)) {
			throw new MigrationFileInvalidException(
				sprintf(
					'Migration file [%s] exists.',
					$filename
				)
			);
		}

		$templateTags['phx:class'] = Helper::getQualifiedClassName($filename);

		$builder = new TemplateBuilder($this->cmd, $this->env);
		$builder->createClassTemplate('migration', $filename, $migrationsDirectory, $templateTags);

		// After migration class has been created, the record needs to go to the database and be set to pending.
		$model = new Model();
		$model->class_name = $templateTags['phx:class'];
		$model->status = Attribute::STATUS_PENDING;
		$model->path = $path;
		$model->save();

		$this->env->sendOutput('Created migration is now pending', 'green');
	}

	/**
	* Runs all migrations.
	*
	* @access 	protected
	* @return 	<void>
	*/
	protected function processMigrations()
	{
		$this->migrator->runMigrations(
			$this->cmd->getConfigOpt('migrations_storage')
		);
	}

	/**
	* Processes a specific migration.
	*
	* @access 	protected
	* @return 	<void>
	*/
	protected function processMigration()
	{

	}

}