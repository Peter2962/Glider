<?php
/**
* @author 	Peter Taiwo
* @package 	Glider\Result\Collection
*/

namespace Glider\Result;

use Closure;
use StdClass;
use Glider\Result\Contract\CollectionContract;
use Glider\Statements\Contract\StatementProvider;
use Glider\Result\Exceptions\FunctionNotFoundException;

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
	public function __construct($statementProvider, $statement)
	{
		if ($statementProvider instanceof StatementProvider) {
			$this->collected = $statementProvider->getResult();
		}else{
			if (gettype($statementProvider) == 'array') {
				$this->collected = $statementProvider;
			}
		}

		$this->statement = $statement;
	}

	/**
	* {@inheritDoc}
	*/
	public function statement()
	{
		return $this->statement;
	}

	/**
	* {@inheritDoc}
	*/
	public function reset() : CollectionContract
	{
		$this->collected = [];
		return $this;
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
		if (!empty($columns) && !empty($this->collected)) {
			// Map columns array to generate filtered columns.
			$newCollection = array_map(function($collected) use ($columns) {
				$collectedObject = new StdClass();
				
				array_map(function($column) use ($collected, $collectedObject) {
					if (isset($collected->$column)) {
						$collectedObject->$column = $collected->$column;
					}
				}, $columns);

				return $collectedObject;
			}, $this->collected);

			// Return new collection instance for collected columns.
			return new self($newCollection, $this->statement);
		}

		return null;
	}

	/**
	* {@inheritDoc}
	*/
	public function size() : int
	{
		return count($this->collected);
	}

	/**
	* {@inheritDoc}
	*/
	public function add($data) : CollectionContract
	{
		array_push($this->collected, $data);
		return $this;
	}

	/**
	* {@inheritDoc}
	*/
	public function remove($key) : CollectionContract
	{
		if (isset($this->collected[$key])) {
			unset($this->collected[$key]);
		}

		return $this;
	}

	/**
	* {@inheritDoc}
	*/
	public function removeWhere(String $key, $value) : CollectionContract
	{
		if ($this->size() > 0) {
			array_map(function($collected, $index) use ($key, $value) {
				if (isset($collected->$key) && $collected->$key == $value) {
					unset($this->collected[$index]);
				}
			}, $this->collected, array_keys($this->collected));
		}

		return $this;
	}

	/**
	* {@inheritDoc}
	*/
	public function map(Array $elements, Closure $callback) : CollectionContract
	{
		array_map(function($element, $index) use ($callback, $elements) {
			call_user_func_array($callback, [
				$element, $index
			]);
		}, $elements, array_keys($elements));

		return $this;
	}

	/**
	* {@inheritDoc}
	*/
	public function toArray(Array $elements=[]) : CollectionContract
	{
		if (sizeof($elements) > 0) {
			$this->collected = $elements;
		}

		$list = array_map(function($element, $index) {
			
			if ($element instanceof StdClass) {
				return (Array) $element;
			}

			if (is_array($element)) {
				// If it's an array, run a recursive function to convert all objects
				// to array.
				return $this->toArray($element)->all();
			}

		}, $this->collected, array_keys($this->collected));

		$this->collected = $list;
		return $this;
	}

	/**
	* {@inheritDoc}
	*/
	public function invoke(Array $elements, String $functionName) : CollectionContract
	{
		if (!function_exists($functionName)) {
			throw new FunctionNotFoundException(sprintf("Function %s does not exist", $functionName));
		}

		$this->map($elements, function($element, $index) use ($functionName) {
			call_user_func_array($functionName, [$element, $index]);
		});

		return $this;
	}

	/**
	* {@inheritDoc}
	*/
	public function max($elements=[], String $with=null)
	{
		if ($elements instanceof CollectionContract) {
			// If $elements is an instance of CollectionContract, we'll get the collected
			// elements.
			$elements = $elements->all();
		}

		if (sizeof($elements) > 0) {
			$this->collected = $elements;
		}

		$list = array_map(function($element, $index) use ($with, $elements) {
			// Is index an integer and element is not array or object? Is element a numeric indexed array?
			if (is_int($index) || is_string($index)) {
				if (!$with == null && isset($element[$with])) {
					return $element[$with];
				}else{
					if (is_int($elements[$index])) {
						return $elements[$index];
					}
				}
			}
		}, $this->collected, array_keys($this->collected));

		return max($list);
	}

	/**
	* {@inheritDoc}
	*/
	public function min($elements=[], String $with=null)
	{
		if ($elements instanceof CollectionContract) {
			// If $elements is an instance of CollectionContract, we'll get the collected
			// elements.
			$elements = $elements->all();
		}

		if (sizeof($elements) > 0) {
			$this->collected = $elements;
		}

		$list = array_map(function($element, $index) use ($with, $elements) {
			// Is index an integer and element is not array or object? Is element a numeric indexed array?
			if (is_int($index) || is_string($index)) {
				if (!$with == null && isset($element[$with])) {
					return $element[$with];
				}else{
					if (is_int($elements[$index])) {
						return $elements[$index];
					}
				}
			}
		}, $this->collected, array_keys($this->collected));

		return min($list);
	}

	/**
	* {@inheritDoc}
	*/
	public function groupBy(String $key) : CollectionContract
	{
		if ($this->size() > 0) {
			$list = [];
			$newCollection = [];
			foreach($this->all() as $index => $element) {
				if (is_array($element) && isset($element[$key])) {
					echo $element[$key];
					continue;
				}

				if (is_object($element) && isset($element->$key)) {
					// If element has already been added to group, append to the group
					// with the same key.

					if (isset($list[$element->$key])) {
						
						// Save previous collected list(s)
						$collected = $list[$element->$key];
						$elementKey = $element->$key;
						$newCollection[$elementKey][] = $element;
						$newCollection[$elementKey][] = $collected;
						continue;
					}

					$list[$element->$key] = $element;
					$newCollection[$element->$key] = [$element];
					continue;
				}
			}
		}

		$this->collected = $newCollection;
		return $this;
	}

	/**
	* {@inheritDoc}
	*/
	public function partition(int $to) : CollectionContract
	{
		$this->collected = array_chunk($this->collected, $to);
		return $this;
	}

	/**
	* {@inheritDoc}
	*/
	public function flatten(Bool $singleLevel=false) : CollectionContract
	{
		$collection = array_map(function($element, $index) {
			if (is_array($element)) {
				return (new self($element, null))->flatten()->first();
			}

			return iterator_to_array(new \RecursiveIteratorIterator(new \RecursiveArrayIterator($element)));
		}, $this->collected, array_keys($this->collected));

		$this->collected = $collection;
		return $this;
	}

}