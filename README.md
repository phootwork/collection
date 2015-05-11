# PHP Collections library

[![Build Status](https://travis-ci.org/gossi/collection.svg?branch=master)](https://travis-ci.org/gossi/collection)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/gossi/collection/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/gossi/collection/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/gossi/collection/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/gossi/collection/?branch=master)

PHP Collections library, which contains ArrayList, Set, Map, Queue & Stack.

## Installation

Install via Composer:

```json
{
	"require": {
		"gossi/collection": "~1"
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

```
$list = new ArrayList([1, 2, 3, 4, 5, 6]);
$list2 = $list->filter(function ($item) {
	return $item & 1;
});
print_r($list2); // [1, 3, 5]
```

### Mapping

Mapping works with anonymous functions:

```
$list = new ArrayList([2, 3, 4]);
$list2 = $list->map(function ($item) {
	return $item * $item;
});
print_r($list2); // [4, 9, 16]
```

## Contributing

Feel free to fork and submit a pull request (don't forget the tests) and I am happy to merge.

## Changelog

Version 1.1 - *Oktober, 18th 2014*

* Full phpdoc
* Added clone functionality

Version 1.0 - *September, 24th 2014*

* Initial release
