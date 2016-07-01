<?php
namespace phootwork\collection\tests;

use phootwork\collection\CollectionUtils;
use phootwork\collection\ArrayList;
use phootwork\collection\Map;
use phootwork\collection\tests\fixtures\DummyIteratorClass;

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

		$this->assertEquals($list, $coll);
	}

	/**
     * @expectedException \InvalidArgumentException
     */
	public function testInvalidArgument() {
		CollectionUtils::fromCollection(1);
	}

	public function testToMap() {
		$data = [['a' => 'b'], ['c' => 'd'], [1, 2, 3]];
		$map = CollectionUtils::toMap($data);

		$this->assertTrue($map instanceof Map);
		$this->assertTrue($map->get(0) instanceof Map);
		$this->assertTrue($map->get(2) instanceof ArrayList);

		$map = new Map($data);
		$this->assertFalse($map->get(0) instanceof Map);
		$this->assertFalse($map->get(2) instanceof ArrayList);
	}

	public function testToList() {
		$data = ['a' => 'b', 'c' => [1, ['x' => 'y'], 4], 'd' => ['x' => 'y', 'z' => 'zz']];
		$list = CollectionUtils::toList($data);

		$this->assertTrue($list instanceof ArrayList);
		$this->assertEquals('b', $list->get(0));
		$this->assertTrue($list->get(2) instanceof Map);

		$list = new ArrayList($data);
		$this->assertEquals('b', $list->get(0));
		$this->assertFalse($list->get(2) instanceof Map);
	}

	public function testNonsense() {
		$dummy = new DummyIteratorClass(range(10, 20));

		$map = CollectionUtils::fromCollection($dummy);

		$this->assertTrue($map instanceof Map);
	}

	public function testToRecursiveArray() {
		$data = ['a' => 'b', 'c' => [1, ['x' => 'y'], 4], 'd' => ['x' => 'y', 'z' => 'zz']];
		$collection = CollectionUtils::fromCollection($data);

		$this->assertEquals($data, CollectionUtils::toArrayRecursive($collection));
	}
}
