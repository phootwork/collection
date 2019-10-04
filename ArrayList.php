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
use phootwork\lang\parts\AccessorsPart;
use phootwork\lang\parts\AddPart;
use phootwork\lang\parts\InsertPart;

/**
 * Represents a List
 * 
 * @author Thomas Gossmann
 * @author Cristiano Cinotti
 */
class ArrayList extends AbstractList {
	use AccessorsPart {
		get as traitGet;
	}
	use AddPart;
	use InsertPart;

	/**
	 * Creates a new ArrayList
	 * 
	 * @param array|Iterator $collection
	 */
	public function __construct($collection = []) {
		foreach ($collection as $element) {
			$this->add($element);
		}
	}

	/**
	 * Removes an element from the list by its index.
	 *
	 * @param int $index
	 *
	 * @return ArrayList
	 */
	public function removeByIndex(int $index): self {
		if (isset($this->array[$index])) {
			unset($this->array[$index]);
		}

		return $this;
	}

	/**
	 * Returns the element at the given index (or null if the index isn't present)
	 *
	 * @param int $index
	 *
	 * @return mixed
	 */
	public function get(int $index) {
		return $this->traitGet($index);
	}
}
