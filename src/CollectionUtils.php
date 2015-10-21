<?php
namespace phootwork\collection;

class CollectionUtils {
	
	/**
	 * Returns a proper collection for the given array (works with nested collections)
	 * 
	 * @param array|Collection $array
	 * @return Map|ArrayList the collection
	 * @throws \InvalidArgumentException
	 */
	public static function fromCollection($array) {
		if ($array instanceof Collection) {
			return $array;
		}
		
		if (!is_array($array)) {
			throw new \InvalidArgumentException('$array is not an array');
		}
		
		return self::toCollection(json_decode(json_encode($array)));
	}
	
	/**
	 * @deprecated use fromCollection instead
	 * @param array $array
	 * @return Map|ArrayList the collection
	 */
	public static function fromArray($array) {
		return self::fromCollection($array);
	}
	
	private static function toCollection($data) {
		if (is_object($data)) {
			$map = new Map();
			foreach ($data as $k => $v) {
				if (is_object($v) || is_array($v)) {
					$map->set($k, self::toCollection($v));
				} else {
					$map->set($k, $v);
				}
			}
				
			return $map;
		} else if (is_array($data)) {
			$list = new ArrayList(); 
			foreach ($data as $v) {
				$list->add(is_object($v) || is_array($v) ? self::toCollection($v) : $v);
			}
			return $list;
		}
	}
	
}
