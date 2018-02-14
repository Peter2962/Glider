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
* @package 	Kit\Glider\ClassLoader
*/

namespace Kit\Glider;

use StdClass;
use ReflectionCLass;
use ReflectionMethod;
use ReflectionException;

class ClassLoader
{

	/**
	* Returns an instance of a class.
	*
	* @param 	$class <Object>
	* @param 	$arguments <Array>
	* @access 	public
	* @return 	Mixed
	*/
	public function getInstanceOfClass($class, ...$arguments)
	{
		return $this->callClassMethod($class, '__construct', $arguments);
	}

	/**
	* Calls a method of a class object.
	*
	* @param 	$class Object
	* @param 	$method <String>
	* @param 	$arguments <Array>
	* @access 	public
	* @return 	Mixed
	*/
	public function callClassMethod($class, $method, ...$arguments)
	{
		$resolvedParameters = [];
		$reflectedClass = new ReflectionCLass($class);
		if (!$reflectedClass->hasMethod($method)) {
			throw new ReflectionException('Call to undefined method ' . $method);
		}

		$methodName = $method;
		$method = $reflectedClass->getMethod($method);
		$methodParameters = $method->getParameters();

		if (count($methodParameters) < 1) {
			return $method;
		}

		$resolvedParameters = array_map(function($param) use ($reflectedClass) {
			$type = $param->getType();

			if (preg_match("/(.*?)\\\/", $type)) {
				$type = (String) $type;
				return new $type;
			}

			if (!$param->isDefaultValueAvailable()) {
				return $param = '';
			}

			return $param->getDefaultValue();
			
		}, $methodParameters);

		$resolvedParameters = array_filter($resolvedParameters);
		$resolvedParameters = array_merge($resolvedParameters, $arguments);

		if ($methodName == '__construct') {
			return $reflectedClass->newInstanceArgs($resolvedParameters);
		}

		return $method->invokeArgs($class, $resolvedParameters);
	}

}