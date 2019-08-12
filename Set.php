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
	public function add($element): self {
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
	public function addAll($collection): self {
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
	public function remove($element): self {
		$index = array_search($element, $this->collection, true);
		if ($index !== false) {
			unset($this->collection[$index]);
		}

		return $this;
	}

	/**
	 * Removes all elements from the set
	 *
	 * @param array|Iterator $collection
	 *
	 * @return $this
	 */
	public function removeAll($collection): self {
		foreach ($collection as $element) {
			$this->remove($element);
		}

		return $this;
	}
}
