<?php
namespace phootwork\collection\tests;

use phootwork\collection\Set;
use phootwork\collection\tests\fixtures\Item;

class SetTest extends \PHPUnit_Framework_TestCase {
	
	public function testAddRemove() {
		$item1 = 'item 1';
		$item2 = 'item 2';
		$item3 = 'item 3';
		$items = [$item1, $item2];
		
		$set = new Set();
		$set->add($item1);
		
		$this->assertEquals(1, $set->size());
		
		$set->remove($item1);
		
		$this->assertEquals(0, $set->size());
		
		$set->addAll($items);
		
		$this->assertEquals(2, $set->size());
		$this->assertSame($items, $set->toArray());
		
		$set->add($item3);
		
		$this->assertEquals(3, $set->size());
		
		$set->removeAll($items);
		
		$this->assertEquals(1, $set->size());
	}
	
	public function testDuplicateValues() {
		$item1 = 'item 1';
		
		$set = new Set();
		$set->add($item1)->add($item1)->add($item1);
		
		$this->assertEquals(1, $set->size());
	}
	
	public function testContains() {
		$item1 = 'item 1';
		$item2 = 'item 2';
		$item3 = 'item 3';
		$items = [$item1, $item2];
	
		$set = new Set($items);
	
		$this->assertTrue($set->contains($item2));
		$this->assertFalse($set->contains($item3));
	}
	
	public function testMap() {
		$set = new Set([2, 3, 4]);
		$set2 = $set->map(function ($item) {
			return $item * $item;
		});
		
		$this->assertSame([4, 9, 16], $set2->toArray());
	}

	public function testFilter() {
		$set = new Set([1, 2, 3, 4, 5, 6]);
		$set2 = $set->filter(function ($item) {
			return $item & 1;
		});
		
		$this->assertSame([1, 3, 5], $set2->toArray());
	}
	
	public function testClone() {
		$set = new Set([1, 2, 3, 4, 5, 6]);
		$clone = clone $set;
	
		$this->assertTrue($clone instanceof Set);
		$this->assertEquals($set, $clone);
		$this->assertEquals($set->toArray(), $clone->toArray());
		$this->assertNotSame($set, $clone);
	}

    /**
     * Test item recursion issues.
     */
	public function testAddRecursion()
    {
        $item1 = new Item();
        $item2 = new Item($item1);
        $item1->setContent($item2);

        $set = new Set();
        $set
            ->add($item1)
            ->add($item2);
        ;

        $this->assertEquals(2, $set->size());
    }
}
