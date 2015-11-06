<?php
namespace phootwork\collection;

use \Iterator;
use phootwork\lang\Comparator;

/**
 * Represents a Map
 * 
 * @author Thomas Gossmann
 */
class Map extends AbstractCollection implements \ArrayAccess {
	
	/**
	 * Creates a new Map
	 * 
	 * @param array|Iterator $collection
	 */
	public function __construct($collection = []) {
		$this->setAll($collection);
	}
	
	/**
	 * Sets an element with the given key on that map
	 * 
	 * @param string key
	 * @param mixed $element
	 * @return Map $this
	 */
	public function set($key, $element) {
		$this->collection[$key] = $element;
		
		return $this;
	}
	
	/**
	 * Returns the element for the given key or your value, if the key doesn't exist.
	 * 
	 * @param string $key
	 * @param mixed $default the return value, if the key doesn't exist
	 * @return mixed
	 */
	public function get($key, $default = null) {
		if (isset($this->collection[$key])) {
			return $this->collection[$key];
		} else {
			return $default;
		}
	}
	
	/**
	 * Returns the key for the given value
	 * 
	 * @param mixed $value the value
	 * @return mixed
	 */
	public function getKey($value) {
		$flipped = array_flip($this->collection);
		if (isset($flipped[$value])) {
			return $flipped[$value];
		}
		
		return null;
	}

	/**
	 * Sets many elements on that map
	 * 
	 * @param array|Iterator $collection
	 * @return Map $this
	 */
	public function setAll($collection) {
		foreach ($collection as $key => $element) {
			$this->set($key, $element);
		}
		
		return $this;
	}
	
	/**
	 * Removes and returns an element from the map by the given key. Returns null if the key
	 * does not exist.
	 * 
	 * @param string $key
	 * @return mixed the element at the given key
	 */
	public function remove($key) {
		if (isset($this->collection[$key])) {
			$element = $this->collection[$key];
			unset($this->collection[$key]);
			
			return $element;
		}
	}
	
	/**
	 * Returns all keys as Set
	 * 
	 * @return Set the map's keys
	 */
	public function keys() {
		return new Set(array_keys($this->collection));
	}
	
	/**
	 * Returns all values as ArrayList
	 * 
	 * @return ArrayList the map's values
	 */
	public function values() {
		return new ArrayList(array_values($this->collection));
	}

	/**
	 * Returns whether the key exist.
	 * 
	 * @param string $key
	 * @return boolean
	 */
	public function has($key) {
		return isset($this->collection[$key]);
	}
	
	/**
	 * Sorts the map
	 *
	 * @param Comparator|callable $cmp
	 * @return $this
	 */
	public function sort($cmp = null) {
		$this->doSort($this->collection, $cmp, 'uasort', 'asort');
	
		return $this;
	}
	
	/**
	 * Sorts the map by keys
	 *
	 * @param Comparator|callable $cmp
	 * @return $this
	 */
	public function sortKeys($cmp = null) {
		$this->doSort($this->collection, $cmp, 'uksort', 'ksort');
	
		return $this;
	}
	
	/**
	 * Iterates the map and calls the callback function with the current key and value as parameters
	 *
	 * @param callable $callback
	 */
	public function each(callable $callback) {
		foreach ($this->collection as $key => $value) {
			$callback($key, $value);
		}
	}

	/**
	 * @internal
	 */
	public function offsetSet($offset, $value) {
		if (!is_null($offset)) {
			$this->collection[$offset] = $value;
		}
	}
	
	/**
	 * @internal
	 */
	public function offsetExists($offset) {
		return isset($this->collection[$offset]);
	}
	
	/**
	 * @internal
	 */
	public function offsetUnset($offset) {
		unset($this->collection[$offset]);
	}
	
	/**
	 * @internal
	 */
	public function offsetGet($offset) {
		return isset($this->collection[$offset]) ? $this->collection[$offset] : null;
	}	
	
}
