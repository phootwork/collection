<?php
namespace phootwork\collection\tests;

use phootwork\collection\Stack;

class StackTest extends \PHPUnit_Framework_TestCase {
	
	public function testAddRemove() {
		$item1 = 'item 1';
		$item2 = 'item 2';
		$item3 = 'item 3';
		$items = [$item1, $item2];
		
		$stack = new Stack();
		$stack->push($item1);
		
		$this->assertEquals(1, $stack->size());
		$this->assertEquals($item1, $stack->pop());
		
		$this->assertEquals(0, $stack->size());
		
		$stack->pushAll($items);
		
		$this->assertEquals(2, $stack->size());

		$stack->push($item3);

		$this->assertEquals(3, $stack->size());
	}
	
	public function testToArray() {
		$item1 = 'item 1';
		$item2 = 'item 2';
		$item3 = 'item 3';
		$items = [$item1, $item2, $item3];
		
		$stack = new Stack($items);
		$this->assertSame(array_reverse($items), $stack->toArray());
	}
	
	public function testDuplicateValues() {
		$item1 = 'item 1';
		
		$stack = new Stack();
		$stack->push($item1)->push($item1)->push($item1);
		
		$this->assertEquals(3, $stack->size());
	}
	
	public function testOrder() {
		$item1 = 'item 1';
		$item2 = 'item 2';
		$item3 = 'item 3';
		$items = [$item1, $item2, $item3];
		
		$stack = new Stack($items);
		$this->assertSame($item3, $stack->peek());
		
		$pops = [];
		$iters = [];
		
		foreach ($stack as $element) {
			$iters[] = $element;
		}
		
		while (($item = $stack->pop()) !== null) {
			$pops[] = $item;
		}
		
		$this->assertSame($iters, $pops);
		
		$stack->clear();
		$this->assertNull($stack->peek());
	}
	
	public function testContains() {
		$item1 = 'item 1';
		$item2 = 'item 2';
		$item3 = 'item 3';
		$items = [$item1, $item2];
	
		$stack = new Stack($items);
	
		$this->assertTrue($stack->contains($item2));
		$this->assertFalse($stack->contains($item3));
	}
	
	public function testClone() {
		$stack = new Stack([1, 2, 3, 4, 5, 6]);
		$clone = clone $stack;
	
		$this->assertTrue($clone instanceof Stack);
		$this->assertEquals($stack, $clone);
		$this->assertEquals($stack->toArray(), $clone->toArray());
		$this->assertNotSame($stack, $clone);
	}
	
}
