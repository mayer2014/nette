<?php

/**
 * Test: Nette\Caching\Storages\FileStorage int keys.
 */

use Nette\Caching\Cache;
use Nette\Caching\Storages\FileStorage;
use Tester\Assert;


require __DIR__ . '/../bootstrap.php';


// key and data with special chars
$key = 0;
$value = range("\x00", "\xFF");

$cache = new Cache(new FileStorage(TEMP_DIR));

Assert::false(isset($cache[$key]));

Assert::null($cache[$key]);


// Writing cache...
$cache[$key] = $value;

Assert::true(isset($cache[$key]));

Assert::same($cache[$key], $value);


// Removing from cache using unset()...
unset($cache[$key]);

Assert::false(isset($cache[$key]));


// Removing from cache using set NULL...
$cache[$key] = $value;
$cache[$key] = NULL;

Assert::false(isset($cache[$key]));
