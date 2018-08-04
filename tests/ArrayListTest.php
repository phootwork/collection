<?php
namespace phootwork\collection\tests;

use phootwork\collection\ArrayList;
use phootwork\collection\tests\fixtures\Item;
use phootwork\lang\ComparableComparator;

class ArrayListTest extends \PHPUnit_Framework_TestCase {

	public function testAddGetRemove() {
		$item1 = 'item 1';
		$item2 = 'item 2';
		$item3 = 'item 3';
		$items = [$item1, $item2];

		$list = new ArrayList();

		$list->add($item1);

		$this->assertEquals(1, $list->size());
		$this->assertEquals($list->get(0), $item1);
		$this->assertNull($list->get(5));

		$list->remove($item1);

		$this->assertEquals(0, $list->size());

		$list->addAll($items);

		$this->assertEquals(2, $list->size());
		$this->assertEmpty($list->get(2));
		$this->assertSame($items, $list->toArray());

		$list->add($item3);

		$this->assertEquals(3, $list->size());

		$list->removeAll($items);

		$this->assertEquals(1, $list->size());
	}

	public function testDuplicateValues() {
		$item1 = 'item 1';

		$list = new ArrayList();
		$list->add($item1)->add($item1)->add($item1);

		$this->assertEquals(3, $list->size());
	}

	public function testIndex() {
		$item1 = 'item 1';
		$item2 = 'item 2';
		$item3 = 'item 3';
		$items = [$item1, $item2];

		$list = new ArrayList($items);

		$index1 = $list->indexOf($item1);
		$this->assertEquals(0, $index1);
		$this->assertEquals(1, $list->indexOf($item2));
		$this->assertFalse($list->indexOf($item3));

		$list->removeAll($items);
		$list->addAll($items);

		$this->assertEquals(2, $list->size());
		$this->assertEquals($index1, $list->indexOf($item1));

		$list->add($item3, 1);
		$this->assertEquals($item3, $list->get(1));
		$this->assertEquals($item2, $list->get(2));
	}

	public function testContains() {
		$item1 = 'item 1';
		$item2 = 'item 2';
		$item3 = 'item 3';
		$items = [$item1, $item2];

		$list = new ArrayList($items);

		$this->assertTrue($list->contains($item2));
		$this->assertFalse($list->contains($item3));
	}

	public function testMap() {
		$list = new ArrayList([2, 3, 4]);
		$list2 = $list->map(function ($item) {
			return $item * $item;
		});

		$this->assertSame([4, 9, 16], $list2->toArray());
	}

	public function testFilter() {
		$list = new ArrayList([1, 2, 3, 4, 5, 6]);
		$list2 = $list->filter(function ($item) {
			return $item & 1;
		});

		$this->assertSame([1, 3, 5], $list2->toArray());
	}

	public function testReduce() {
		$list = new ArrayList(range(1, 10));
		$sum = $list->reduce(function($a, $b) {return $a + $b;});

		$this->assertEquals(55, $sum);
	}

	public function testClone() {
		$list = new ArrayList([1, 2, 3, 4, 5, 6]);
		$clone = clone $list;

		$this->assertTrue($clone instanceof ArrayList);
		$this->assertEquals($list, $clone);
		$this->assertEquals($list->toArray(), $clone->toArray());
		$this->assertNotSame($list, $clone);
	}

	public function testSearch() {
		$list = new ArrayList(range(1, 10));
		$search = function ($elem, $query) {return $elem == $query;};

		$this->assertTrue($list->search(4, $search));
		$this->assertFalse($list->search(20, $search));

		$this->assertTrue($list->search(function ($elem) {
			return $elem == 4;
		}));
		$this->assertFalse($list->search(function ($elem) {
			return $elem == 20;
		}));
	}

	public function testSortAndReverse() {
		$unsorted = [5, 2, 8, 3, 9, 4, 6, 1, 7, 10];
		$list = new ArrayList($unsorted);

		$this->assertEquals([10, 7, 1, 6, 4, 9, 3, 8, 2, 5], $list->reverse()->toArray());
		$this->assertEquals(range(1, 10), $list->sort()->toArray());

		$list = new ArrayList($unsorted);
		$this->assertEquals(range(10, 1), $list->reverseSort()->toArray());

		$list = new ArrayList($unsorted);
		$cmp = function ($a, $b) {
			if ($a == $b) {
				return 0;
			}
			return ($a < $b) ? -1 : 1;
		};
		$this->assertEquals(range(1, 10), $list->sort($cmp)->toArray());

		$items = ['x', 'c', 'a', 't', 'm'];
		$list = new ArrayList();
		foreach ($items as $item) {
			$list->add(new Item($item));
		}
		$list->sort(new ComparableComparator());
		$this->assertEquals(['a', 'c', 'm', 't', 'x'], $list->map(function ($item) {return $item->getContent();})->toArray());
	}

	public function testEach() {
		$result = [];
		$list = new ArrayList(range(1, 10));
		$list->each(function ($value) use (&$result) {
			$result[] = $value;
		});
		$this->assertEquals($list->toArray(), $result);
	}

	public function testFind() {
		$list = new ArrayList(range(1, 10));
		$list = $list->map(function ($item) {
			return new Item($item);
		});

		$search = function ($i, $query) {
			return $i->getContent() == $query;
		};

		$item = $list->find(4, $search);
		$this->assertTrue($item instanceof Item);
		$this->assertEquals(4, $item->getContent());
		$this->assertEquals(3, $list->findIndex(4, $search));
		$this->assertNull($list->find(20, $search));

		$fruits = new ArrayList(['apple', 'banana', 'pine', 'banana', 'ananas']);
		$fruits = $fruits->map(function ($item) {
			return new Item($item);
		});
		$this->assertEquals(1, $fruits->findIndex(function ($elem) {
			return $elem->getContent() == 'banana';
		}));
		$this->assertEquals(3, $fruits->findLastIndex(function ($elem) {
			return $elem->getContent() == 'banana';
		}));
		$this->assertEquals(3, $fruits->findLastIndex('banana', function ($elem, $query) {
			return $elem->getContent() == $query;
		}));
		$this->assertNull($fruits->findLast('mango', function ($elem, $query) {
			return $elem->getContent() == $query;
		}));

		$apples = $fruits->findAll('apple', function ($elem, $query) {
			return $elem->getContent() == $query;
		});
		$this->assertEquals(1, $apples->size());

		$bananas = $fruits->findAll(function ($elem) {
			return $elem->getContent() == 'banana';
		});
		$this->assertEquals(2, $bananas->size());
	}

	public function testSome() {
		$list = new ArrayList(range(1, 10));

		$this->assertTrue($list->some(function ($item) {
			return $item % 2 === 0;
		}));

		$this->assertFalse($list->some(function ($item) {
			return $item > 10;
		}));

		$list = new ArrayList();
		$this->assertFalse($list->some(function () {
			return true;
		}));
	}

	public function testEvery() {
		$list = new ArrayList(range(1, 10));

		$this->assertTrue($list->every(function ($item) {
			return $item <= 10;
		}));

		$this->assertFalse($list->every(function ($item) {
			return $item > 10;
		}));

		$list = new ArrayList();
		$this->assertTrue($list->every(function () {
			return true;
		}));
	}
}
