<?php
namespace phootwork\collection;

/**
 * Collection interface
 *
 * @author Thomas Gossmann
 */
interface Collection extends \Iterator {
	
	/**
	 * Resets the collection
	 * 
	 * @return void
	 */
	public function clear();
	
	/**
	 * Checks whether this collection is empty
	 * 
	 * @return boolean
	 */
	public function isEmpty();
	
	/**
	 * Checks whether the given element is in this collection
	 * 
	 * @param mixed $element
	 * @return boolean
	 */
	public function contains($element);
	
	/**
	 * Returns the amount of elements in this collection
	 * 
	 * @return integer
	 */
	public function size();

	/**
	 * Returns the collection as an array
	 * 
	 * @return array
	 */
	public function toArray();
}
