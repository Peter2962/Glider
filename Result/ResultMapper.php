<?php
/**
* @package 	ResultMapper
* @version 	0.1.0
*
* ResultMapper helps to define properties that would be accessed in a result set.
* All ResultMapper classes must extend this class.
* The properties access can be either public/protected/private. But making it private
* is more recommended.
*
*/

namespace Glider\Result;

use ReflectionClass;
use Glider\Result\Contract\ResultMapperContract;

abstract Class ResultMapper implements ResultMapperContract
{

	/**
	* @access 	public
	* @return 	void
	*/
	public function register() : Bool
	{
		return $this->register();
	}

	/**
	* {@inheritDoc}
	*/
	public function getFields()
	{
		$subClass = get_called_class();
	}

}