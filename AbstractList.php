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

use phootwork\lang\Comparator;
use phootwork\lang\parts\EachPart;
use phootwork\lang\parts\IndexFindersPart;
use phootwork\lang\parts\ReducePart;
use phootwork\lang\parts\RemovePart;
use phootwork\lang\parts\ReversePart;

/**
 * Abstract class for all list-like collections
 *
 * @author Thomas Gossmann
 * @author Cristiano Cinotti
 */
abstract class AbstractList extends AbstractCollection {
	use EachPart;
	use IndexFindersPart {
		indexOf as traitIndexOf;
		findLastIndex as traitFindLastIndex;
		findIndex as traitFindIndex;
	}
	use ReducePart;
	use RemovePart;
	use ReversePart;

	/**
	 * Sorts the collection in reverse order
	 * 
	 * @see #sort
	 * @see #reverse
	 *
	 * @param Comparator|callable $cmp
	 *
	 * @return $this
	 */
	public function reverseSort($cmp = null): self {
		return $this->sort($cmp)->reverse();
	}

	/**
	 * Returns the index of the given element or null if the element can't be found
	 *
	 * @param mixed $element
	 *
	 * @return int the index for the given element
	 */
	public function indexOf($element): ?int {
		$index = $this->traitIndexOf($element);

		return $index === null ? $index : (int) $index;
	}

	/**
	 * Searches the array with a given callback and returns the index for the last element if found.
	 *
	 * The callback function takes one or two parameters:
	 *
	 *     function ($element [, $query]) {}
	 *
	 * The callback must return a boolean
	 * When it's passed, $query must be the first argument:
	 *
	 *     - find($query, callback)
	 *     - find(callback)
	 *
	 * @param array $arguments
	 *
	 * @return int|null the index or null if it hasn't been found
	 */
	public function findLastIndex(...$arguments): ?int {
		$lastIndex = $this->traitFindLastIndex(...$arguments);

		return $lastIndex === null ? $lastIndex : (int) $lastIndex;
	}

	/**
	 * Searches the array with a given callback and returns the index for the first element if found.
	 *
	 * The callback function takes one or two parameters:
	 *
	 *     function ($element [, $query]) {}
	 *
	 * The callback must return a boolean
	 * When it's passed, $query must be the first argument:
	 *
	 *     - find($query, callback)
	 *     - find(callback)
	 *
	 * @param array $arguments
	 *
	 * @return int|null the index or null if it hasn't been found
	 */
	public function findIndex(...$arguments): ?int {
		$index = $this->traitFindIndex(...$arguments);

		return $index === null ? $index : (int) $index;
	}
}
