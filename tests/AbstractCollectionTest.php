<?php
namespace phootwork\collection\tests;

use phootwork\collection\ArrayList;
use phootwork\collection\CollectionUtils;

class AbstractCollectionTest extends \PHPUnit_Framework_TestCase {

	public function testSize() {
		$list = new ArrayList();

		$this->assertTrue($list->isEmpty());
		$this->assertEquals(0, $list->size());

		$list->add('item 1')->add('item 2');

		$this->assertFalse($list->isEmpty());
		$this->assertEquals(2, $list->size());

		$list->clear();

		$this->assertTrue($list->isEmpty());
		$this->assertEquals(0, $list->size());

		$list = new ArrayList(['item 1', 'item 2']);

		$this->assertFalse($list->isEmpty());
		$this->assertEquals(2, $list->size());
	}

	public function testIterator() {
		$data = ['item 1', 'item 2'];
		$list = new ArrayList($data);
		$elements = [];
		$keyelems = [];
		$counter = 0;

		foreach ($list as $element) {
			$elements[] = $element;
			$counter++;
		}

		foreach ($list as $key => $element) {
			$keyelems[$key] = $element;
		}

		$this->assertEquals(2, $counter);
		$this->assertSame($data, $elements);
		$this->assertSame($elements, $keyelems);
	}

	public function testExport() {
		$data = [1, 2, ['a' => 'b', 'c' => [7, 8, 9]], 4];
		$list = CollectionUtils::fromCollection($data);
		$this->assertEquals(4, count($list->toArray()));

		$data = ['a' => 'b', 'c' => [1, ['x' => 'y'], 4], 'd' => 'e'];
		$map = CollectionUtils::fromCollection($data);
		$this->assertEquals(3, count($map->toArray()));
	}

}
