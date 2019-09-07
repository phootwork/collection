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

use Iterator;
use phootwork\lang\parts\AddAllPart;

/**
 * Represents a Set
 *
 * @author Thomas Gossmann
 */
class Set extends AbstractList {
	use AddAllPart;

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
	 *
	 * @return $this
	 */
	public function add($element): self {
		if (!in_array($element, $this->array, true)) {
			$this->array[$this->size()] = $element;
		}

		return $this;
	}
}
