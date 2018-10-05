<?php
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
	public function add($element, $index = null) {
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
	public function addAll($collection) {
		foreach ($collection as $element) {
			$this->add($element);
		}
		
		return $this;
	}

	/**
	 * Removes an element from the list
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
	 * Removes all elements from the list
	 *
	 * @param array|Iterator $collection
	 * @return $this
	 */
	public function removeAll($collection) {
		foreach ($collection as $element) {
			$this->remove($element);
		}
		
		return $this;
	}

}
