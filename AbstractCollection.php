<?php
namespace phootwork\collection;

use phootwork\lang\Comparator;

/**
 * AbstractCollection providing implemention for the Collection interface.
 *
 * @author Thomas Gossmann
 */
abstract class AbstractCollection implements Collection {

	protected $collection = [];

	public function contains($element) {
		return in_array($element, $this->collection, true);
	}

	public function size() {
		return count($this->collection);
	}

	public function isEmpty() {
		return count($this->collection) == 0;
	}

	public function clear() {
		$this->collection = [];
	}

	public function toArray() {
		return $this->collection;
	}

	/**
	 * Applies the callback to the elements
	 *
	 * @param callable $callback the applied callback function
	 * @return static
	 */
	public function map(callable $callback) {
		return new static(array_map($callback, $this->collection));
	}

	/**
	 * Filters elements using a callback function
	 *
	 * @param callable $callback the filter function
	 * @return static
	 */
	public function filter(callable $callback) {
		return new static(array_filter($this->collection, $callback));
	}

	/**
	 * Tests whether all elements in the collection pass the test implemented by the provided function.
	 *
	 * Returns <code>true</code> for an empty collection.
	 *
	 * @param callable $callback
	 * @return boolean
	 */
	public function every(callable $callback) {
		$match = true;
		foreach ($this->collection as $element) {
			$match = $match && $callback($element);
		}

		return $match;
	}

	/**
	 * Tests whether at least one element in the collection passes the test implemented by the provided function.
	 *
	 * Returns <code>false</code> for an empty collection.
	 *
	 * @param callable $callback
	 * @return boolean
	 */
	public function some(callable $callback) {
		$match = false;
		foreach ($this->collection as $element) {
			$match = $match || $callback($element);
		}

		return $match;
	}

	/**
	 * Searches the collection for query using the callback function on each element
	 *
	 * The callback function takes one or two parameters:
	 *
	 *     function ($element [, $query]) {}
	 *
	 * The callback must return a boolean
	 *
	 * @param mixed $query (optional)
	 * @param callable $callback
	 * @return boolean
	 */
	public function search() {
		if (func_num_args() == 1) {
			$callback = func_get_arg(0);
		} else {
			$query = func_get_arg(0);
			$callback = func_get_arg(1);
		}

		foreach ($this->collection as $element) {
			$return = func_num_args() == 1 ? $callback($element) : $callback($element, $query);

			if ($return) {
				return true;
			}
		}
		return false;
	}

	/**
	 * Searches the collection with a given callback and returns the first element if found.
	 *
	 * The callback function takes one or two parameters:
	 *
	 *     function ($element [, $query]) {}
	 *
	 * The callback must return a boolean
	 *
	 * @param mixed $query OPTIONAL the provided query
	 * @param callable $callback the callback function
	 * @return mixed|null the found element or null if it hasn't been found
	 */
	public function find() {
		if (func_num_args() == 1) {
			$callback = func_get_arg(0);
		} else {
			$query = func_get_arg(0);
			$callback = func_get_arg(1);
		}

		foreach ($this->collection as $element) {
			$return = func_num_args() == 1 ? $callback($element) : $callback($element, $query);

			if ($return) {
				return $element;
			}
		}

		return null;
	}

	/**
	 * Searches the collection with a given callback and returns the last element if found.
	 *
	 * The callback function takes one or two parameters:
	 *
	 *     function ($element [, $query]) {}
	 *
	 * The callback must return a boolean
	 *
	 * @param mixed $query OPTIONAL the provided query
	 * @param callable $callback the callback function
	 * @return mixed|null the found element or null if it hasn't been found
	 */
	public function findLast() {
		if (func_num_args() == 1) {
			$callback = func_get_arg(0);
		} else {
			$query = func_get_arg(0);
			$callback = func_get_arg(1);
		}

		$reverse = array_reverse($this->collection, true);
		foreach ($reverse as $element) {
			$return = func_num_args() == 1 ? $callback($element) : $callback($element, $query);

			if ($return) {
				return $element;
			}
		}

		return null;
	}

	/**
	 * Searches the collection with a given callback and returns all matching elements.
	 *
	 * The callback function takes one or two parameters:
	 *
	 *     function ($element [, $query]) {}
	 *
	 * The callback must return a boolean
	 *
	 * @param mixed $query OPTIONAL the provided query
	 * @param callable $callback the callback function
	 * @return mixed|null the found element or null if it hasn't been found
	 */
	public function findAll() {
		if (func_num_args() == 1) {
			$callback = func_get_arg(0);
		} else {
			$query = func_get_arg(0);
			$callback = func_get_arg(1);
		}

		$collection = [];
		foreach ($this->collection as $k => $element) {
			$return = func_num_args() == 1 ? $callback($element) : $callback($element, $query);

			if ($return) {
				$collection[$k] = $element;
			}
		}

		return new static($collection);
	}

	/**
	 * Internal sort function
	 *
	 * @param array $collection the collection on which is operated on
	 * @param Comparator|callable|null $cmp the compare function
	 * @param callable $usort the sort function for user passed $cmd
	 * @param callable $sort the default sort function
	 */
	protected function doSort(&$collection, $cmp, callable $usort, callable $sort) {
		if (is_callable($cmp)) {
			$usort($collection, $cmp);
		} else if ($cmp instanceof Comparator) {
			$usort($collection, function($a, $b) use ($cmp) {
				return $cmp->compare($a, $b);
			});
		} else {
			$sort($collection);
		}
	}

	/**
	 * @internal
	 */
	public function rewind() {
		return reset($this->collection);
	}

	/**
	 * @internal
	 */
	public function current() {
		return current($this->collection);
	}

	/**
	 * @internal
	 */
	public function key() {
		return key($this->collection);
	}

	/**
	 * @internal
	 */
	public function next() {
		return next($this->collection);
	}

	/**
	 * @internal
	 */
	public function valid() {
		return key($this->collection) !== null;
	}

	/**
	 * @internal
	 */
	public function __clone() {
		return new static($this->collection);
	}

}