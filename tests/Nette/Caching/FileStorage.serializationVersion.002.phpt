<?php

/**
 * Test: Nette\Caching\Storages\FileStorage @serializationVersion dependency test (continue...).
 */

use Nette\Caching\Cache;
use Nette\Caching\Storages\FileStorage;
use Tester\Assert;


require __DIR__ . '/../bootstrap.php';


$key = 'nette';
$value = 'rulez';


$cache = new Cache(new FileStorage(TEMP_DIR));


/**
 * @serializationVersion 123
 */
class Foo
{
}


// Changed @serializationVersion

Assert::false(isset($cache[$key]));
