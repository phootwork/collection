<?php
namespace phootwork\collection;

use \Iterator;

/**
 * Represents a Stack
 * 
 * FILO - first in last out
 * 
 * @author Thomas Gossmann
 */
class Stack extends AbstractList {

	/**
	 * Creates a new ArrayList
	 * 
	 * @param array|Iterator $collection
	 */
	public function __construct($collection = []) {
		$this->pushAll($collection);
	}
	
	/**
	 * Pushes an element onto the stack
	 * 
	 * @param mixed $element
	 * @return $this
	 */
	public function push($element) {
		array_push($this->collection, $element);
		
		return $this;
	}
	
	/**
	 * Pushes many elements onto the stack
	 *
	 * @param array|Iterator $collection
	 * @return $this
	 */
	public function pushAll($collection) {
		foreach ($collection as $element) {
			$this->push($element);
		}
		
		return $this;
	}
	
	/**
	 * Returns the element at the head or null if the stack is empty but doesn't remove that element  
	 * 
	 * @return mixed
	 */
	public function peek() {
		if ($this->size() > 0) {
			return $this->collection[$this->size() - 1];
		}

		return null;
	}
	
	/**
	 * Pops the element at the head from the stack or null if the stack is empty
	 * 
	 * @return mixed
	 */
	public function pop() {
		return array_pop($this->collection);
	}

}