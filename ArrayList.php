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

/**
 * Represents a List
 * 
 * @author Thomas Gossmann
 */
class ArrayList extends AbstractList {
	
	/**
	 * Creates a new ArrayList
	 * 
	 * @param array|Iterator $collection
	 */
	public function __construct($collection = []) {
		$this->addAll($collection);
	}
	
	/**
	 * Adds an element to that list
	 * 
	 * @param mixed $element
	 * @param int $index
	 * @return $this
	 */
	public function add($element, int $index = null): self {
		if ($index === null) {
			$this->collection[$this->size()] = $element;
		} else {
			array_splice($this->collection, $index, 0, $element);
		}
		
		return $this;
	}
	
	/**
	 * Adds all elements to the list
	 * 
	 * @param array|Iterator $collection
	 * @return $this
	 */
	public function addAll($collection): self {
		foreach ($collection as $element) {
			$this->add($element);
		}
		
		return $this;
	}

	/**
	 * Returns the element at the given index (or null if the index isn't present)
	 * 
	 * @param int $index
	 * @return mixed
	 */
	public function get(int $index) {
		if (isset($this->collection[$index])) {
			return $this->collection[$index];
		}

		return null;
	}

	/**
	 * Returns the index of the given element or null if the element can't be found
	 * 
	 * @param mixed $element
	 * @return int the index for the given element
	 */
	public function indexOf($element): ?int {
		$output = array_search($element, $this->collection, true);

		return false === $output ? null : $output;
	}
	
	/**
	 * Removes an element from the list
	 * 
	 * @param mixed $element
	 * @return $this
	 */
	public function remove($element): self {
		if (null !== $index = $this->indexOf($element)) {
			$this->removeByIndex($index);
		}

		return $this;
	}

	/**
	 * Removes an element from the list by its index.
	 *
	 * @param int $index
	 * @return ArrayList
	 */
	public function removeByIndex(int $index): self {
		if (isset($this->collection[$index])) {
			unset($this->collection[$index]);
		}

		return $this;
	}

	/**
	 * Removes all elements from the list
	 *
	 * @param array|Iterator $collection
	 * @return $this
	 */
	public function removeAll($collection): self {
		foreach ($collection as $element) {
			$this->remove($element);
		}
		
		return $this;
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
	public function findIndex(): ?int {
		if (func_num_args() == 1) {
			$index = $this->find(func_get_arg(0));
		} else {
			$index = $this->find(func_get_arg(0), func_get_arg(1));
		}

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
	public function findLastIndex(): ?int {
		if (func_num_args() == 1) {
			$index = $this->findLast(func_get_arg(0));
		} else {
			$index = $this->findLast(func_get_arg(0), func_get_arg(1));
		}

		if ($index !== null) {
			$index = $this->indexOf($index);
		}

		return $index;
	}
}
