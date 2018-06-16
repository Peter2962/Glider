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

use Kit\Console\Command;
use Kit\Console\Environment;
use Kit\Console\Contract\Runnable;

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
		//
	}

	/**
	* {@inheritDoc}
	*/
	public function runnableCommands() : Array
	{
		return [];
	}

}