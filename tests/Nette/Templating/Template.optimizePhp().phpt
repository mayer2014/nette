<?php

/**
 * Test: Nette\Templating\Helpers::optimizePhp()
 */

use Nette\Templating\Helpers;
use Tester\Assert;


require __DIR__ . '/../bootstrap.php';


$input = file_get_contents(__DIR__ . '/templates/optimize.phtml');
$expected = file_get_contents(__DIR__ . '/Template.optimizePhp().expect');
Assert::match($expected, Helpers::optimizePhp($input));
