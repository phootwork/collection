<?php
namespace phootwork\collection;

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
		return $this->collection;
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