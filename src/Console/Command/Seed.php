<?php
/**
* @author 		Peter Taiwo <peter@phoxphp.com>
* @package 		Kit\Glider\Console\Command\Seed
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
use Kit\Console\Contract\Runnable;
use Kit\Glider\Console\TemplateBuilder;
use Kit\Glider\Seed\Exceptions\SeederNotFoundException;
use Kit\Glider\Seed\Exceptions\SeedFileInvalidException;

class Seed implements Runnable
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
	* {@inheritDoc}
	*/
	public function __construct(Environment $env, Command $cmd)
	{
		$this->env = $env;
		$this->cmd = $cmd;
	}

	/**
	* {@inheritDoc}
	*/
	public function getId() : String
	{
		return 'seed';
	}

	/**
	* {@inheritDoc}
	*/
	public function run(Array $argumentsList, int $argumentsCount)
	{
		$command = $argumentsList[0];
		unset($argumentsList[0]);
		$arguments = array_values($argumentsList);

		switch ($command) {
			case 'create':
				return $this->createSeed();
				break;
			case 'run':
				return $this->runSeeds();
				break;
			case 'run-class':
				$path = $this->cmd->getConfigOpt('seeds_storage') . '/' . trim($arguments[0]) . '.php';
				include $path;
				return $this->runSeed(basename($path, '.php'));
				break;
			default:
				return $this->env->sendOutput('No command run.');
				break;
		}
	}

	/**
	* {@inheritDoc}
	*/
	public function runnableCommands() : Array
	{
		return [
			'run' => ':none',
			'create' => ':none',
			'run-class' => 1,
		];
	}

	/**
	* Create new seed class.
	*
	* @access 	protected
	* @return 	<void>
	*/
	protected function createSeed()
	{
		$templateTags = [];
		$seedsDirectory = $this->cmd->getConfigOpt('seeds_storage');

		$filename = trim($this->cmd->question('Seed filename?'));
		$templateTags['phx:class'] = Helper::getQualifiedClassName($filename);

		$path = $seedsDirectory . '/' . $filename . '.php';

		if (file_exists($path)) {
			throw new SeedFileInvalidException(
				sprintf(
					'Seed file [%s] exists.',
					$filename
				)
			);
		}

		$builder = new TemplateBuilder($this->cmd, $this->env);
		$builder->createClassTemplate('seed', $filename, $seedsDirectory, $templateTags);
	}

	/**
	* Runs all seeders.
	*
	* @access 	protected
	* @return 	<void>
	*/
	protected function runSeeds()
	{
		foreach($this->getSeeders() as $file) {
			require_once $file;
			$className = basename($file, '.php');
			$this->runSeed($className);
		}
	}

	/**
	* Runs a single seeder.
	*
	* @param 	$className <String>
	* @access 	protected
	* @return 	<void>
	*/
	protected function runSeed(String $className)
	{
		if (!class_exists($className)) {
			throw new SeederNotFoundException(
				sprintf(
					'[%s] seeder class not found.',
					$className
				)
			);
		}

		$seeder = new $className();
		return $seeder->run();
	}

	/**
	* Returns an array of seeder files.
	*
	* @access 	protected
	* @return 	<Array>
	*/
	protected function getSeeders() : Array
	{
		$seeders = [];
		$seedsDirectory = $this->cmd->getConfigOpt('seeds_storage');
		foreach(glob($seedsDirectory . '/*' . '.php') as $file) {
			$seeders[] = $file;
		}

		return $seeders;
	}

}