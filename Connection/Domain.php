<?php
namespace Glider\Connection;

abstract class Domain
{

	/**
	* Checks if the server host matches provided domain(s). A single
	* domain (string) or array of domains can be provided.
	*
	* @param 	$providedDomain <String>
	* @access 	public
	* @static
	* @return 	Boolean
	*/
	public static function matches(Type $providedDomain)
	{
		if (is_string($providedDomain)) {
			return (Boolean) $_SERVER['HTTP_HOST'] == $providedDomain;
		}

		if (is_array($providedDomain)) {
			if (in_array($_SERVER['HTTP_HOST'], $providedDomain)) {
				return true;
			}
		}

		return false;
	}

}