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
		return in_array($element, $this->collection);
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
		return array_map(function ($v) {
			if (is_object($v) && method_exists($v, 'toArray')) {
				return $v->toArray();
			}
			return $v;
		}, $this->collection);
	}
	
	/**
	 * @return static
	 */
	public function map(callable $callback) {
		return new static(array_map($callback, $this->collection));
	}
	
	/**
	 * @return static
	 */
	public function filter(callable $callback) {
		return new static(array_filter($this->collection, $callback));
	}
	
	/**
	 * Searches the collection for query using the callback function on each element
	 * 
	 * @param string $query
	 * @param callable $callback
	 * @return boolean
	 */
	public function search($query, callable $callback) {
		foreach ($this->collection as $element) {
			if ($callback($element, $query)) {
				return true;
			}
		}
		return false;
	}
	
	/**
	 * Internal sort function
	 * 
	 * @param array $collection the collection on which is operated on
	 * @param Comparator|callable $cmp the compare function
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