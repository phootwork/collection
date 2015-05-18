<?php
namespace phootwork\collection\tests;

use phootwork\collection\CollectionUtils;
use phootwork\collection\ArrayList;
use phootwork\collection\Map;

class CollectionUtilsTest extends \PHPUnit_Framework_TestCase {
	
	public function testList() {
		$data = [1, 2, 4];
		
		$list = CollectionUtils::fromArray($data);
		
		$this->assertTrue($list instanceof ArrayList);
	}
	
	public function testMap() {
		$data = ['a' => 'b', 'c' => 'd'];
		
		$map = CollectionUtils::fromArray($data);
		
		$this->assertTrue($map instanceof Map);
	}
	
	public function testComplex() {
		$data = [['a' => 'b'], ['c' => 'd']];
		$list = CollectionUtils::fromArray($data);
		
		$this->assertTrue($list instanceof ArrayList);
		$this->assertTrue($list->get(1) instanceof Map);
		
		$data = ['a' => [1, 2, 3], 'c' => 'd'];
		$map = CollectionUtils::fromArray($data);
		
		$this->assertTrue($map instanceof Map);
		$this->assertTrue($map->get('a') instanceof ArrayList);
	}
	
}
