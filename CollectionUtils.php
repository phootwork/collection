<?php
namespace phootwork\collection;

use \Iterator;
use \InvalidArgumentException;

/**
 * CollectionUtils help to transform data recursively into collections.
 *
 * It must be mentioned the API is experimental and may change. Please
 * report to the issue tracker.
 */
class CollectionUtils {

	/**
	 * Returns a proper collection for the given array (also transforms nested collections)
	 * (experimental API)
	 *
	 * @param array|Iterator $collection
	 * @return Map|ArrayList the collection
	 * @throws InvalidArgumentException
	 */
	public static function fromCollection($collection) {
		if (!(is_array($collection) || $collection instanceof Iterator)) {
			throw new InvalidArgumentException('$collection is neither an array nor an iterator');
		}

		return self::toCollection($collection);
	}

	private static function toCollection($data) {
		// prepare normal array
		if (!($data instanceof Iterator)) {
			$data = json_decode(json_encode($data));
		}

		// check if we can transform it into a collection or just return as is
		if (!(is_array($data) || $data instanceof Iterator || $data instanceof \stdClass)) {
			return $data;
		}

		// check we have a list
		if (is_array($data) || $data instanceof AbstractList) {
			return self::toList($data);
		}

		// everything else must be a map
		return self::toMap($data);
	}

	/**
	 * Recursively transforms data into a map (on the first level, deeper levels
	 * transformed to an appropriate collection) (experimental API)
	 *
	 * @param array|Iterator $collection
	 * @return Map
	 */
	public static function toMap($collection) {
		$map = new Map();
		foreach ($collection as $k => $v) {
			$map->set($k, self::toCollection($v));
		}

		return $map;
	}

	/**
	 * Recursively transforms data into a list (on the first level, deeper levels
	 * transformed to an appropriate collection) (experimental API)
	 *
	 * @param array|Iterator $collection
	 * @return ArrayList
	 */
	public static function toList($collection) {
		$list = new ArrayList();
		foreach ($collection as $v) {
			$list->add(self::toCollection($v));
		}
		return $list;
	}

	/**
	 * Recursively exports a collection to an array
	 *
	 * @param mixed $collection
	 * @return array
	 */
	public static function toArrayRecursive($collection) {
		$arr = $collection;
		if (is_object($collection) && method_exists($collection, 'toArray')) {
			$arr = $collection->toArray();
		}

		return array_map(function ($v) {
			if (is_object($v) && method_exists($v, 'toArray')) {
				return static::toArrayRecursive($v);
			}
			return $v;
		}, $arr);
	}

}
