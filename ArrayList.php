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
use phootwork\lang\parts\AccessorsPart;
use phootwork\lang\parts\AddAllPart;
use phootwork\lang\parts\AddPart;

/**
 * Represents a List
 * 
 * @author Thomas Gossmann
 */
class ArrayList extends AbstractList {

	use AccessorsPart, AddPart, AddAllPart;

	/**
	 * Creates a new ArrayList
	 * 
	 * @param array|Iterator $collection
	 */
	public function __construct($collection = []) {
		$this->addAll($collection);
	}

	/**
	 * Removes an element from the list by its index.
	 *
	 * @param int $index
	 * @return ArrayList
	 */
	public function removeByIndex(int $index): self {
		if (isset($this->array[$index])) {
			unset($this->array[$index]);
		}

		return $this;
	}
}
