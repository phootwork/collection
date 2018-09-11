<?php
namespace phootwork\collection;

use \Iterator;

/**
 * Represents a Set
 *
 * @author Thomas Gossmann
 */
class Set extends AbstractList {

	/**
	 * Creates a new Set
	 *
	 * @param array|Iterator $collection
	 */
	public function __construct($collection = []) {
		$this->addAll($collection);
	}

	/**
	 * Adds an element to that set
	 *
	 * @param mixed $element
	 * @return $this
	 */
	public function add($element) {
		if (!in_array($element, $this->collection, true)) {
			$this->collection[$this->size()] = $element;
		}

		return $this;
	}

	/**
	 * Adds all elements to the set
	 *
	 * @param array|Iterator $collection
	 * @return $this
	 */
	public function addAll($collection) {
		foreach ($collection as $element) {
			$this->add($element);
		}

		return $this;
	}

	/**
	 * Removes an element from the set
	 *
	 * @param mixed $element
	 * @return $this
	 */
	public function remove($element) {
		$index = array_search($element, $this->collection, true);
		if ($index !== null) {
			unset($this->collection[$index]);
		}

		return $this;
	}

	/**
	 * Removes all elements from the set
	 *
	 * @param array|Iterator $collection
	 */
	public function removeAll($collection) {
		foreach ($collection as $element) {
			$this->remove($element);
		}
	}

}