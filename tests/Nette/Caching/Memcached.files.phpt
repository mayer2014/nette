<?php

/**
 * Test: Nette\Caching\Storages\MemcachedStorage files dependency test.
 */

use Nette\Caching\Storages\MemcachedStorage;
use Nette\Caching\Cache;
use Tester\Assert;


require __DIR__ . '/../bootstrap.php';


if (!MemcachedStorage::isAvailable()) {
	Tester\Environment::skip('Requires PHP extension Memcache.');
}


$key = 'nette-files-key';
$value = 'rulez';

$cache = new Cache(new MemcachedStorage('localhost'));


$dependentFile = TEMP_DIR . '/spec.file';
@unlink($dependentFile);

// Writing cache...
$cache->save($key, $value, array(
	Cache::FILES => array(
		__FILE__,
		$dependentFile,
	),
));

Assert::true(isset($cache[$key]));


// Modifing dependent file
file_put_contents($dependentFile, 'a');

Assert::false(isset($cache[$key]));


// Writing cache...
$cache->save($key, $value, array(
	Cache::FILES => $dependentFile,
));

Assert::true(isset($cache[$key]));


// Modifing dependent file
sleep(2);
file_put_contents($dependentFile, 'b');
clearstatcache();

Assert::false(isset($cache[$key]));
