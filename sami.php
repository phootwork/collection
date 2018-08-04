<?php
require_once __DIR__ . '/vendor/autoload.php';

use Sami\Parser\Filter\PublicFilter;
use Symfony\Component\Finder\Finder;
use Sami\Sami;

$iterator = Finder::create()->files()->name('*.php')->in(__DIR__ . '/src');

$sami = new Sami($iterator, [
	'title' => 'Phootwork Collection API',
	'theme' => 'default',
	'build_dir' => __DIR__ . '/api',
	'default_opened_level' => 2,
	'sort_class_properties' => true,
	'sort_class_methods' => true,
	'sort_class_constants' => true,
	'sort_class_traits' => true,
	'sort_class_interfaces' => true
]);

$sami['filter'] = function () {
	return new PublicFilter();
};

return $sami;