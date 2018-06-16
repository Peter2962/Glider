<?php
/**
* @author 		Peter Taiwo <peter@phoxphp.com>
* @package 		Kit\Glider\Console\TemplateBuilder
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

namespace Kit\Glider\Console;

use RuntimeException;
use Kit\Console\Command;
use Kit\Console\Environment;

class TemplateBuilder
{

	/**
	* @var 		$cmd
	* @access 	protected
	*/
	protected 	$cmd;

	/**
	* @var 		$env
	* @access 	protected
	*/
	protected 	$env;

	/**
	* TemplateBuilder construct.
	*
	* @param 	$cmd <Kit\Console\Command>
	* @param 	$cmd <Kit\Console\Environment>
	* @access 	public
	* @return 	<void>
	*/
	public function __construct(Command $cmd, Environment $env)
	{
		$this->cmd = $cmd;
		$this->env = $env;
	}

	/**
	* Builds a class template.
	*
	* @param 	$templateName <String>
	* @param 	$filename <String>
	* @param 	$savePath <String>
	* @param 	$templateTags <Array>
	* @access 	public
	* @return 	<void>
	*/
	public function createClassTemplate(String $templateName, String $filename, $savePath=null, Array $templateTags)
	{
		$template = file_get_contents(__DIR__ . '/templates/' . $templateName);
		foreach($templateTags as $key => $tag) {
			if (!preg_match_all('/' . $key . '/', $template)) {
				throw new RuntimeException(sprintf('[%s] tag does not exist in template.', $key));
			}
		}

		if (!is_dir($savePath) || !is_readable($savePath)) {
			throw new RuntimeException(sprintf('[%s] directory is not readable', $savePath));
		}

		$template = str_replace(
			array_keys($templateTags),
			array_values($templateTags),
			$template
		);

		$file = $savePath . '/' . $filename . '.php';
		$handle = fopen($file, 'w+');
		fwrite($handle, $template);
		fclose($handle);

		$this->env->sendOutput(
			sprintf(
				'[%s] class has been generated and placed in [%s]',
				$templateTags['phx:class'],
				$file
			),
			'green',
			'black'
		);
	}

}