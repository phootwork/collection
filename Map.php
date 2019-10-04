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

use Iterator;
use phootwork\lang\AbstractArray;
use phootwork\lang\Comparator;
use phootwork\lang\parts\SortAssocPart;
use phootwork\lang\Text;

/**
 * Represents a Map
 * 
 * @author Thomas Gossmann
 */
class Map extends AbstractCollection implements \ArrayAccess {
	use SortAssocPart;

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
	 *
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
	 *
	 * @return Map $this
	 */
	public function set($key, $element): self {
		$key = $this->extractKey($key);
		$this->array[$key] = $element;

		return $this;
	}

	/**
	 * Returns the element for the given key or your value, if the key doesn't exist.
	 * 
	 * @param string|Text $key
	 * @param mixed $default the return value, if the key doesn't exist
	 *
	 * @return mixed
	 */
	public function get($key, $default = null) {
		$key = $this->extractKey($key);
		if (isset($this->array[$key])) {
			return $this->array[$key];
		} else {
			return $default;
		}
	}

	/**
	 * Returns the key for the given value
	 * 
	 * @param mixed $value the value
	 *
	 * @return mixed
	 */
	public function getKey($value) {
		foreach ($this->array as $k => $v) {
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
	 *
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
	 *
	 * @return $this
	 */
	public function remove($key): self {
		$key = $this->extractKey($key);
		if (isset($this->array[$key])) {
			unset($this->array[$key]);
		}

		return $this;
	}

	/**
	 * Returns all keys as Set
	 * 
	 * @return Set the map's keys
	 */
	public function keys(): Set {
		return new Set(array_keys($this->array));
	}

	/**
	 * Returns all values as ArrayList
	 * 
	 * @return ArrayList the map's values
	 */
	public function values(): ArrayList {
		return new ArrayList(array_values($this->array));
	}

	/**
	 * Returns whether the key exist.
	 * 
	 * @param string|Text $key
	 *
	 * @return bool
	 */
	public function has($key): bool {
		$key = $this->extractKey($key);

		return isset($this->array[$key]);
	}

	/**
	 * Sorts the map
	 *
	 * @param Comparator|callable $cmp
	 *
	 * @return $this
	 */
	public function sort($cmp = null): AbstractArray {
		return $this->sortAssoc($cmp);
	}

	/**
	 * Iterates the map and calls the callback function with the current key and value as parameters
	 *
	 * @param callable $callback
	 */
	public function each(callable $callback): void {
		foreach ($this->array as $key => $value) {
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
	 * When it's passed, $query must be the first argument:
	 *
	 *     - find($query, callback)
	 *     - find(callback)
	 *
	 * @param array $arguments
	 *
	 * @return mixed|null the key or null if it hasn't been found
	 */
	public function findKey(...$arguments) {
		$index = count($arguments) === 1 ? $this->find($arguments[0]) : $this->find($arguments[0], $arguments[1]);

		return $this->getKey($index);
	}

	/**
	 * Searches the collection with a given callback and returns the key for the last element if found.
	 *
	 * The callback function takes one or two parameters:
	 *
	 *     function ($element [, $query]) {}
	 *
	 * The callback must return a boolean
	 * When it's passed, $query must be the first argument:
	 *
	 *     - find($query, callback)
	 *     - find(callback)
	 *
	 * @param array $arguments
	 *
	 * @return mixed|null the key or null if it hasn't been found
	 */
	public function findLastKey(...$arguments) {
		$index = count($arguments) === 1 ? $this->findLast($arguments[0]) : $this->findLast($arguments[0], $arguments[1]);

		return $this->getKey($index);
	}

	/**
	 * @internal
	 */
	public function offsetSet($offset, $value) {
		if (!is_null($offset)) {
			$this->array[$offset] = $value;
		}
	}

	/**
	 * @internal
	 */
	public function offsetExists($offset) {
		return isset($this->array[$offset]);
	}

	/**
	 * @internal
	 */
	public function offsetUnset($offset) {
		unset($this->array[$offset]);
	}

	/**
	 * @internal
	 */
	public function offsetGet($offset) {
		return isset($this->array[$offset]) ? $this->array[$offset] : null;
	}
}
