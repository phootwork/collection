<?php
namespace phootwork\collection;

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
	 * @param array|Collection $array
	 * @return Map|ArrayList the collection
	 * @throws \InvalidArgumentException
	 */
	public static function fromCollection($array) {
		if (!self::isCollection($array)) {
			throw new \InvalidArgumentException('$array is not an array or collection');
		}
		
		return self::toCollection($array);
	}
	
	/**
	 * @deprecated use fromCollection instead (will be removed in version 1.3)
	 * @param array $array
	 * @return Map|ArrayList the collection
	 */
	public static function fromArray($array) {
		return self::fromCollection($array);
	}
	
	private static function toCollection($data) {
		if (!($data instanceof Collection)) {
			$data = json_decode(json_encode($data));
		}

		if (is_array($data) || $data instanceof ArrayList) {
			return self::toList($data);
		} else if (is_object($data) || $data instanceof Map) {
			return self::toMap($data);
		}
		
		return $data;
	}
	
	/**
	 * Recursively transforms data into a map (on the first level, deeper levels 
	 * transformed to an appropriate collection) (experimental API)
	 * 
	 * @param array $data
	 * @return Map
	 */
	public static function toMap($data) {
		$map = new Map();
		foreach ($data as $k => $v) {
			$map->set($k, self::toCollection($v));
		}
		
		return $map;
	}
	
	/**
	 * Recursively transforms data into a list (on the first level, deeper levels 
	 * transformed to an appropriate collection) (experimental API)
	 *
	 * @param array $data
	 * @return ArrayList
	 */
	public static function toList($data) {
		$list = new ArrayList();
		foreach ($data as $v) {
			$list->add(self::toCollection($v));
		}
		return $list;
	}
	
	private static function isCollection($value) {
		return is_object($value) || is_array($value) || $value instanceof Collection;
	}
}
