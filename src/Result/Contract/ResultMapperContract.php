<?php
/**
* @package 	ResultMapperContract
* @version 	0.1.0
*/

namespace Kit\Glider\Result\Contract;

interface ResultMapperContract
{

	/**
	* This method returns an array of map ids and it's values. 
	*
	* @access 	public
	* @return 	Array
	*/
	public function register() : Bool;

}