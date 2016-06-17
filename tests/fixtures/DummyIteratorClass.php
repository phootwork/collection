<?php
namespace phootwork\collection\tests\fixtures;

class DummyIteratorClass implements \Iterator {
	
	private $collection;
	
	public function __construct($contents = []) {
		$this->collection = $contents;
	}
	
	/**
	 * @internal
	 */
	public function rewind() {
		return reset($this->collection);
	}
	
	/**
	 * @internal
	 */
	public function current() {
		return current($this->collection);
	}
	
	/**
	 * @internal
	 */
	public function key() {
		return key($this->collection);
	}
	
	/**
	 * @internal
	 */
	public function next() {
		return next($this->collection);
	}
	
	/**
	 * @internal
	 */
	public function valid() {
		return key($this->collection) !== null;
	}
}