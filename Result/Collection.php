<?php
/**
* @author 	Peter Taiwo
* @package 	Glider\Result\Collection
*/

namespace Glider\Result;

use Glider\Result\Contract\CollectionContract;
use Glider\Statements\Contract\StatementProvider;

class Collection implements CollectionContract
{

	/**
	* @var 		$collected
	* @access 	protected
	*/
	protected 	$collected;

	/**
	* @var 		$statement
	* @access 	protected
	*/
	protected 	$statement;

	/**
	* @var 		$offset
	* @access 	protected
	*/
	protected 	$offset = null;

	/**
	* {@inheritDoc}
	*/
	public function __construct(StatementProvider $statementProvider, $statement)
	{
		$this->collected = $statementProvider->getResult();
		$this->statement = $statement;
	}

	/**
	* {@inheritDoc}
	*/	
	public function all() : Array
	{
		return $this->collected;
	}

	/**
	* {@inheritDoc}
	*/
	public function first()
	{
		if ($this->collected[0]) {
			$this->offset = 0;
		}

		return $this->collected[0] ?? null;
	}

	/**
	* {@inheritDoc}
	*/
	public function next()
	{
		if ($this->offset !== null) {
			$this->offset = $this->offset + 1;
			return $this->collected[$this->offset];
		}

		return null;
	}

	/**
	* {@inheritDoc}
	*/
	public function offset(int $offset=0)
	{
		return $this->collected[$offset] ?? null;
	}

	/**
	* {@inheritDoc}
	*/
	public function only(...$columns)
	{
		if (!empty($columns)) {
			return array_map(function($column) {

			}, $columns);
		}

		return null;
	}

}