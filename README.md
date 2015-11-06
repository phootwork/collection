# PHP Collections library

[![Build Status](https://travis-ci.org/phootwork/collection.svg?branch=master)](https://travis-ci.org/phootwork/collection)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/phootwork/collection/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/phootwork/collection/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/phootwork/collection/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/phootwork/collection/?branch=master)

PHP Collections library, which contains ArrayList, Set, Map, Queue & Stack.

## Installation

Install via Composer:

```json
{
	"require": {
		"phootwork/collection": "~1"
	}
}
```

## Usage


### Collections

These collections are available:

- `ArrayList` - provides a List
- `Set` - provides a Set
- `Map` - provides a Map
- `Queue` - provides a Queue (FIFO - first in first out)
- `Stack` - provides a Stack (FILO - first in last out)

All classes contain phpdoc, so your lovely IDE will provide you with content assist on all the methods.

### Filtering

Filtering works with anonymous functions:

```php
$list = new ArrayList([1, 2, 3, 4, 5, 6]);
$list2 = $list->filter(function ($item) {
	return $item & 1;
});
print_r($list2); // [1, 3, 5]
```

### Mapping

Mapping works with anonymous functions:

```php
$list = new ArrayList([2, 3, 4]);
$list2 = $list->map(function ($item) {
	return $item * $item;
});
print_r($list2); // [4, 9, 16]
```

### Searching

Searching works with an anonymous function to enable you to search your data structure

```php
$list = new ArrayList(range(1, 10));
		
$found = $list->search(4, function ($elem, $query) { // $query has the value 4 as you've just passed in
	return $elem == $query;
});
```

## Contributing

Feel free to fork and submit a pull request (don't forget the tests) and I am happy to merge.

## Changelog

Refer to [Releases](https://github.com/phootwork/collection/releases)