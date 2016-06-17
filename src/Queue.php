<?php
namespace phootwork\collection;

use \Iterator;

/**
 * Represents a Queue
 * 
 * FIFO - first in first out
 * 
 * @author Thomas Gossmann
 */
class Queue extends AbstractList {
	
	/**
	 * Creates a new Queue
	 * 
	 * @param array|Iterator $collection
	 */
	public function __construct($collection = []) {
		$this->enqueueAll($collection);
	}
	
	/**
	 * Enqueues an element
	 * 
	 * @param mixed $element
	 * @return $this
	 */
	public function enqueue($element) {
		$this->collection[$this->size()] = $element;
		
		return $this;
	}
	
	/**
	 * Enqueues many elements
	 *
	 * @param array|Iterator $collection
	 * @return $this
	 */
	public function enqueueAll($collection) {
		foreach ($collection as $element) {
			$this->enqueue($element);
		}
	
		return $this;
	}
	
	/**
	 * Returns the element at the head or null if the queue is empty but doesn't remove that element  
	 * 
	 * @return mixed
	 */
	public function peek() {
		if ($this->size() > 0) {
			return $this->collection[0];
		} else {
			return null;
		}
	}
	
	/**
	 * Removes and returns the element at the head or null if the is empty
	 * 
	 * @return mixed
	 */
	public function poll() {
		return array_shift($this->collection);
	}
	
}