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
		$stack = new Stack(['item 1', 'item 2', 'item 3']);
		$this->assertSame('item 3', $stack->peek());
		$this->assertEquals($stack->toArray(), ['item 1', 'item 2', 'item 3']);
		
		$stack = new Stack();
		$stack->push('item 1')->push('item 2')->push('item 3');
		$this->assertSame('item 3', $stack->peek());
		$this->assertEquals($stack->toArray(), ['item 1', 'item 2', 'item 3']);
		
		$stack = new Stack();
		$stack->pushAll(['item 1', 'item 2', 'item 3']);
		$this->assertSame('item 3', $stack->peek());
		$this->assertEquals($stack->toArray(), ['item 1', 'item 2', 'item 3']);
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
		
		$pops = [];
		$iters = [];
		
		foreach ($stack as $element) {
			$iters[] = $element;
		}
		
		while (($item = $stack->pop()) !== null) {
			$pops[] = $item;
		}
		
		$this->assertSame($iters, array_reverse($pops));
		
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
	
	public function testMap() {
		$cb = function ($item) {
			return strtoupper($item);
		};
		
		$stack = new Stack(['item 1', 'item 2', 'item 3']);
		$this->assertEquals(array_map($cb, $stack->toArray()), $stack->map($cb)->toArray());
	}
	
}
