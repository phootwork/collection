<?php declare(strict_types=1);
/**
 * This file is part of the Phootwork package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 * @copyright Thomas Gossmann
 */

namespace phootwork\collection;

use \Iterator;
use phootwork\lang\Comparator;
use phootwork\lang\Text;

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
	 * @param string|Text $key
	 * @return int|string
	 */
	private function extractKey($key) {
		if ($key instanceof Text) {
			return $key->toString();
		}
		
		return $key;
	}
	
	/**
	 * Sets an element with the given key on that map
	 * 
	 * @param string|Text $key
	 * @param mixed $element
	 * @return Map $this
	 */
	public function set($key, $element): self {
		$key = $this->extractKey($key);
		$this->collection[$key] = $element;
		
		return $this;
	}
	
	/**
	 * Returns the element for the given key or your value, if the key doesn't exist.
	 * 
	 * @param string|Text $key
	 * @param mixed $default the return value, if the key doesn't exist
	 * @return mixed
	 */
	public function get($key, $default = null) {
		$key = $this->extractKey($key);
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
		foreach ($this->collection as $k => $v) {
			if ($v === $value) {
				return $k;
			}
		}
		
		return null;
	}

	/**
	 * Sets many elements on that map
	 * 
	 * @param array|Iterator $collection
	 * @return Map $this
	 */
	public function setAll($collection): self {
		foreach ($collection as $key => $element) {
			$this->set($key, $element);
		}
		
		return $this;
	}
	
	/**
	 * Removes and returns an element from the map by the given key. Returns null if the key
	 * does not exist.
	 * 
	 * @param string|Text $key
	 * @return $this
	 */
	public function remove($key): self {
		$key = $this->extractKey($key);
		if (isset($this->collection[$key])) {
			$element = $this->collection[$key];
			unset($this->collection[$key]);
		}

		return $this;
	}
	
	/**
	 * Returns all keys as Set
	 * 
	 * @return Set the map's keys
	 */
	public function keys(): Set {
		return new Set(array_keys($this->collection));
	}
	
	/**
	 * Returns all values as ArrayList
	 * 
	 * @return ArrayList the map's values
	 */
	public function values(): ArrayList {
		return new ArrayList(array_values($this->collection));
	}

	/**
	 * Returns whether the key exist.
	 * 
	 * @param string|Text $key
	 * @return boolean
	 */
	public function has($key): bool {
		$key = $this->extractKey($key);
		return isset($this->collection[$key]);
	}
	
	/**
	 * Sorts the map
	 *
	 * @param Comparator|callable $cmp
	 * @return $this
	 */
	public function sort($cmp = null): self {
		$this->doSort($this->collection, $cmp, 'uasort', 'asort');
	
		return $this;
	}
	
	/**
	 * Sorts the map by keys
	 *
	 * @param Comparator|callable $cmp
	 * @return $this
	 */
	public function sortKeys($cmp = null): self {
		$this->doSort($this->collection, $cmp, 'uksort', 'ksort');
	
		return $this;
	}
	
	/**
	 * Iterates the map and calls the callback function with the current key and value as parameters
	 *
	 * @param callable $callback
	 */
	public function each(callable $callback): void {
		foreach ($this->collection as $key => $value) {
			$callback($key, $value);
		}
	}
	
	/**
	 * Searches the collection with a given callback and returns the key for the first element if found.
	 *
	 * The callback function takes one or two parameters:
	 *
	 *     function ($element [, $query]) {}
	 *
	 * The callback must return a boolean
	 *
	 * @param mixed $query OPTIONAL the provided query
	 * @param callable $callback the callback function
	 * @return mixed|null the key or null if it hasn't been found
	 */
	public function findKey() {
		if (func_num_args() == 1) {
			$index = $this->find(func_get_arg(0));
		} else {
			$index = $this->find(func_get_arg(0), func_get_arg(1));
		}
		
		if ($index !== null) {
			$index = $this->getKey($index);
		}
	
		return $index;
	}
	
	/**
	 * Searches the collection with a given callback and returns the key for the last element if found.
	 *
	 * The callback function takes one or two parameters:
	 *
	 *     function ($element [, $query]) {}
	 *
	 * The callback must return a boolean
	 *
	 * @param mixed $query OPTIONAL the provided query
	 * @param callable $callback the callback function
	 * @return mixed|null the key or null if it hasn't been found
	 */
	public function findLastKey() {
		if (func_num_args() == 1) {
			$index = $this->findLast(func_get_arg(0));
		} else {
			$index = $this->findLast(func_get_arg(0), func_get_arg(1));
		}

		if ($index !== null) {
			$index = $this->getKey($index);
		}
	
		return $index;
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
