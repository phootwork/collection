<?php
namespace phootwork\collection\tests\fixtures;

use phootwork\lang\Comparable;

class Item implements Comparable {
	
	private $content;
	
	public function __construct($content = '') {
		$this->content = $content;
	}
	
	public function compareTo($comparison) {
		return strcmp($this->content, $comparison->getContent());
	}
	
	/**
	 * @return mixed
	 */
	public function getContent() {
		return $this->content;
	}
	
	/**
	 *
	 * @param mixed $content        	
	 */
	public function setContent($content) {
		$this->content = $content;
		return $this;
	}
	
}