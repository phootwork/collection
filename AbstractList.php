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

use phootwork\lang\Comparator;

/**
 * Abstract class for all list-like collections
 *
 * @author Thomas Gossmann
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
	public function sort($cmp = null): self {
		$this->doSort($this->collection, $cmp, 'usort', 'sort');

		return $this;
	}

	/**
	 * Reverses the order of all elements
	 * 
	 * @return $this
	 */
	public function reverse(): self {
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
	public function reverseSort($cmp = null): self {
		return $this->sort($cmp)->reverse();
	}
	
	/**
	 * Iterates the collection and calls the callback function with the current item as parameter
	 * 
	 * @param callable $callback
	 */
	public function each(callable $callback): void {
		foreach ($this->collection as $item) {
			$callback($item);
		}
	}
}
