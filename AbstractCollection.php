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

use phootwork\lang\AbstractArray;

/**
 * AbstractCollection providing implementation for the Collection interface.
 *
 * @author Thomas Gossmann
 */
abstract class AbstractCollection extends AbstractArray implements Collection {

	/**
	 * Remove all elements from the collection.
	 */
	public function clear(): void {
		$this->array = [];
	}

	/**
	 * @internal
	 */
	public function rewind() {
		return reset($this->array);
	}

	/**
	 * @internal
	 */
	public function current() {
		return current($this->array);
	}

	/**
	 * @internal
	 */
	public function key(): int {
		return key($this->array);
	}

	/**
	 * @internal
	 */
	public function next() {
		return next($this->array);
	}

	/**
	 * @internal
	 */
	public function valid(): bool {
		return key($this->array) !== null;
	}
}
