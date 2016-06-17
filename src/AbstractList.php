<?php
namespace phootwork\collection;

use phootwork\lang\Comparator;

/**
 * Abstract class for all list-like collections
 * 
 */
abstract class AbstractList extends AbstractCollection {

	/**
	 * Iterative reduction of this collection with the help of a callback function. The callback
	 * function takes two parameters, the first is the carry, the second the current item, with this
	 * signature: mixed callback(mixed $carry, mixed $item)
	 *
	 * @param callable $callback the callback function
	 * @param mixed $fallback the default value, that will be returned when the list is empty
	 * @return mixed
	 */
	public function reduce(callable $callback, $fallback = null) {
		return array_reduce($this->collection, $callback, $fallback);
	}

	/**
	 * Sorts the collection.
	 * 
	 * @param Comparator|callable $cmp
	 * @return $this
	 */
	public function sort($cmp = null) {
		$this->doSort($this->collection, $cmp, 'usort', 'sort');

		return $this;
	}

	/**
	 * Reverses the order of all elements
	 * 
	 * @return $this
	 */
	public function reverse() {
		$this->collection = array_reverse($this->collection);
		return $this;
	}

	/**
	 * Sorts the collection in reverse order
	 * 
	 * @see #sort
	 * @see #reverse
	 * @param Comparator|callable $cmp
	 * @return $this
	 */
	public function reverseSort($cmp = null) {
		return $this->sort($cmp)->reverse();
	}
	
	/**
	 * Iterates the collection and calls the callback function with the current item as parameter
	 * 
	 * @param callable $callback
	 */
	public function each(callable $callback) {
		foreach ($this->collection as $item) {
			$callback($item);
		}
	}

	/**
	 * Searches the collection with a given callback and returns the index for the first element if found.
	 *
	 * The callback function takes one or two parameters:
	 *
	 *     function ($element [, $query]) {}
	 *
	 * The callback must return a boolean
	 *
	 * @param mixed $query OPTIONAL the provided query
	 * @param callable $callback the callback function
	 * @return int|null the index or null if it hasn't been found
	 */
	public function findIndex() {
		if (func_num_args() == 1) {
			$callback = func_get_arg(0);
		} else {
			$query = func_get_arg(0);
			$callback = func_get_arg(1);
		}
		
		$index = func_num_args() == 1 ? $this->find($callback) : $this->find($query, $callback);
		if ($index !== null) {
			$index = $this->indexOf($index);
		}
		
		return $index;
	}
	
	/**
	 * Searches the collection with a given callback and returns the index for the last element if found.
	 *
	 * The callback function takes one or two parameters:
	 *
	 *     function ($element [, $query]) {}
	 *
	 * The callback must return a boolean
	 *
	 * @param mixed $query OPTIONAL the provided query
	 * @param callable $callback the callback function
	 * @return int|null the index or null if it hasn't been found
	 */
	public function findLastIndex() {
		if (func_num_args() == 1) {
			$callback = func_get_arg(0);
		} else {
			$query = func_get_arg(0);
			$callback = func_get_arg(1);
		}
		
		$index = func_num_args() == 1 ? $this->findLast($callback) : $this->findLast($query, $callback);
		if ($index !== null) {
			$index = $this->indexOf($index);
		}
	
		return $index;
	}
}
