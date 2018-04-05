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
* @package 	Kit\Glider\Configurator
*/

namespace Kit\Glider;

use Closure;
use Kit\Glider\Connection\QueuedConnections;
use Kit\Glider\Contract\ConfiguratorInterface;

class Configurator implements ConfiguratorInterface
{

	/**
	* Helps to resolve configuration file issues after cloning the framework.
	*
	* @access 	public
	* @return 	void
	* @static
	*/
	public static function fixConfiguration()
	{
		if(file_exists('Config.php')) {
			unlink('Config.php');
		}

		copy('app/vendor/phoxphp/glider/src/config.framework', 'app/vendor/phoxphp/glider/src/Config.php');
	}

}