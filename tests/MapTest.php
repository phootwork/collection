<?php
namespace phootwork\collection\tests;

use phootwork\collection\ArrayList;
use phootwork\collection\Map;
use phootwork\collection\Set;
use phootwork\collection\tests\fixtures\Item;
use phootwork\lang\ComparableComparator;
use phootwork\lang\StringComparator;
use phootwork\lang\Text;

class MapTest extends \PHPUnit_Framework_TestCase {

	public function testAddGetRemove() {
		$key1 = 'key1';
		$key2 = 'key2';
		$key3 = 'key3';
		$item1 = 'item 1';
		$item2 = 'item 2';
		$item3 = 'item 3';
		$items = [$key1 => $item1, $key2 => $item2];
		$keys = new Set([$key1, $key2]);
		$values = new ArrayList([$item1, $item2]);
		
		$map = new Map();
		$map->set($key1, $item1);
		
		$this->assertEquals(1, $map->size());
		$this->assertEquals($item1, $map->get($key1));
		$this->assertEquals($key1, $map->getKey($item1));
		$this->assertNull($map->getKey($item2));
		$this->assertTrue($map->has($key1));
		$this->assertFalse($map->has($key2));
		
		$map->remove($key1);
		
		$this->assertEquals(0, $map->size());
		
		$map->setAll($items);
		
		$this->assertEquals(2, $map->size());
		$this->assertEquals($keys, $map->keys());
		$this->assertEquals($values, $map->values());

		$map->set($key3, $item3);

		$this->assertEquals(3, $map->size());
		
		$map->clear();
		$this->assertEquals(0, $map->size());
		
		$dupKeyItems = [$key1 => $item1, $key2 => $item2];
		$map->setAll($dupKeyItems);
		$map->set($key2, $item3);

		$this->assertEquals(2, $map->size());
		$this->assertEquals($item3, $map->get($key2));
		
		$this->assertEmpty($map->get('non_existing_key'));
		$this->assertEmpty($map->remove('non_existing_key'));
		$this->assertEquals([], $map->get('non_existing_key', []));
	}
	
	public function testToArray() {
		$key1 = 'key1';
		$key2 = 'key2';
		$key3 = 'key3';
		$item1 = 'item 1';
		$item2 = 'item 2';
		$item3 = 'item 3';
		$items = [$key1 => $item1, $key2 => $item2, $key3 => $item3];
		
		$map = new Map($items);
		$this->assertSame($items, $map->toArray());
	}

	public function testMap() {
		$map = new Map(['a' => 'a', 'b' => 'b', 'c' => 'c']);
		$map2 = $map->map(function ($item) {
			return $item . 'val';
		});
	
		$this->assertSame(['a' => 'aval', 'b' => 'bval', 'c' => 'cval'], $map2->toArray());
	}

	public function testFilter() {
		$map = new Map(['a' => 'a', 'b' => 'b', 'c' => 'c']);
		$map2 = $map->filter(function ($item) {
			return $item != 'b';
		});
	
		$this->assertSame(['a' => 'a', 'c' => 'c'], $map2->toArray());
	}

	public function testArrayAccess() {
		$map = new Map();
		$map['a'] = 'b';
		
		$this->assertEquals(1, $map->size());
		$this->assertTrue($map->has('a'));
		$this->assertFalse($map->has('c'));
		$this->assertTrue($map->contains('b'));
		$this->assertFalse($map->contains('c'));
		$this->assertEquals($map['a'], $map->get('a'));
		$this->assertTrue(isset($map['a']));
		$this->assertFalse(isset($map['c']));
		
		$map['a'] = 'x';
		
		$this->assertEquals('x', $map['a']);
		
		unset($map['a']);
		
		$this->assertFalse($map->has('a'));
		$this->assertEquals(0, $map->size());	
	}
	
	public function testClone() {
		$map = new Map(['a' => 'aval', 'b' => 'bval', 'c' => 'cval']);
		$clone = clone $map;
	
		$this->assertTrue($clone instanceof Map);
		$this->assertEquals($map, $clone);
		$this->assertEquals($map->toArray(), $clone->toArray());
		$this->assertNotSame($map, $clone);
	}
	
	public function testSort() {
		$map = new Map(['b' => 'bval', 'a' => 'aval', 'c' => 'cval']);
		$map->sort();
		$this->assertEquals(['a' => 'aval', 'b' => 'bval', 'c' => 'cval'], $map->toArray());
		
		$map = new Map(['b' => 'bval', 'a' => 'aval', 'c' => 'cval']);
		$map->sort(function ($a, $b) {
			if ($a == $b) {
				return 0;
			}
			return ($a < $b) ? -1 : 1;
		});
		$this->assertEquals(['a' => 'aval', 'b' => 'bval', 'c' => 'cval'], $map->toArray());
		
		$map = new Map(['b' => new Item('bval'), 'a' => new Item('aval'), 'c' => new Item('cval')]);
		$map->sort(new ComparableComparator());
		$this->assertEquals(['a' => 'aval', 'b' => 'bval', 'c' => 'cval'], $map
				->map(function ($elem) {return $elem->getContent();})
				->toArray());
	}
	
	public function testSortKeys() {
		$map = new Map(['b' => 'bval', 'a' => 'aval', 'c' => 'cval']);
		$map->sortKeys();
		$this->assertEquals(['a' => 'aval', 'b' => 'bval', 'c' => 'cval'], $map->toArray());
	
		$map = new Map(['b' => 'bval', 'a' => 'aval', 'c' => 'cval']);
		$map->sortKeys(function ($a, $b) {
			if ($a == $b) {
				return 0;
			}
			return ($a < $b) ? -1 : 1;
		});
		$this->assertEquals(['a' => 'aval', 'b' => 'bval', 'c' => 'cval'], $map->toArray());
		
		$map = new Map(['b' => 'bval', 'a' => 'aval', 'c' => 'cval']);
		$map->sortKeys(new StringComparator());
		$this->assertEquals(['a' => 'aval', 'b' => 'bval', 'c' => 'cval'], $map->toArray());
	}
	
	public function testEach() {
		$result = [];
		$map = new Map(['b' => 'bval', 'a' => 'aval', 'c' => 'cval']);
		$map->each(function ($key, $value) use (&$result) {
			$result[$key] = $value;
		});
		$this->assertEquals($map->toArray(), $result);
	}
	
	public function testFind() {
		$fruits = new Map([
			'a' => 'apple', 
			'b' => 'banana', 
			'c' => 'pine', 
			'd' => 'banana', 
			'e' => 'ananas'
		]);
		$fruits = $fruits->map(function ($item) {
			return new Item($item);
		});
		$this->assertEquals('b', $fruits->findKey(function ($elem) {
			return $elem->getContent() == 'banana';
		}));
		$this->assertEquals('b', $fruits->findKey('banana', function ($elem, $query) {
			return $elem->getContent() == $query;
		}));
		$this->assertEquals('d', $fruits->findLastKey(function ($elem) {
			return $elem->getContent() == 'banana';
		}));
		$this->assertEquals('d', $fruits->findLastKey('banana', function ($elem, $query) {
			return $elem->getContent() == $query;
		}));
	}
	
	public function testTextAsKey() {
		$map = new Map();
		$key = new Text('k');
		$map->set($key, 'val');
		$this->assertTrue($map->has($key));
		$this->assertEquals('val', $map->get($key));
		$map->remove($key);
		$this->assertEquals(0, $map->size());
	}
	
}