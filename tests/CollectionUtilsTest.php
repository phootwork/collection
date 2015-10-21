<?php
namespace phootwork\collection\tests;

use phootwork\collection\CollectionUtils;
use phootwork\collection\ArrayList;
use phootwork\collection\Map;

class CollectionUtilsTest extends \PHPUnit_Framework_TestCase {
	
	public function testList() {
		$data = [1, 2, 4];
		
		$list = CollectionUtils::fromCollection($data);
		
		$this->assertTrue($list instanceof ArrayList);
	}
	
	public function testMap() {
		$data = ['a' => 'b', 'c' => 'd'];
		
		$map = CollectionUtils::fromCollection($data);
		
		$this->assertTrue($map instanceof Map);
	}
	
	public function testComplex() {
		$data = [['a' => 'b'], ['c' => 'd']];
		$list = CollectionUtils::fromCollection($data);
		
		$this->assertTrue($list instanceof ArrayList);
		$this->assertTrue($list->get(1) instanceof Map);
		
		$data = ['a' => [1, 2, 3], 'c' => 'd'];
		$map = CollectionUtils::fromCollection($data);
		
		$this->assertTrue($map instanceof Map);
		$this->assertTrue($map->get('a') instanceof ArrayList);
		
		
		$data = ['a' => 'b', 'c' => [1, ['x' => 'y'], 4], 'd' => 'e'];
		$map = CollectionUtils::fromCollection($data);
		$this->assertTrue($map->get('c')->get(1) instanceof Map);
	}
	
	public function testCollectionFromCollection() {
		$list = new ArrayList([1, 2, 3]);
		$coll = CollectionUtils::fromCollection($list);
		
		$this->assertSame($list, $coll);
	}
	
	/**
     * @expectedException \InvalidArgumentException
     */
	public function testInvalidArgument() {
		CollectionUtils::fromCollection(1);
	}
}
