<?php

/**
 * Test: Nette\DI\Config\Adapters\NeonAdapter
 */

use Nette\DI\Config;
use Tester\Assert;


require __DIR__ . '/../bootstrap.php';

define('TEMP_FILE', TEMP_DIR . '/cfg.neon');


$config = new Config\Loader;
$data = $config->load('files/neonAdapter.neon', 'production');
Assert::same(array(
	'webname' => 'the example',
	'database' => array(
		'adapter' => 'pdo_mysql',
		'params' => array(
			'host' => 'db.example.com',
			'username' => 'dbuser',
			'password' => 'secret',
			'dbname' => 'dbname',
		),
	),
), $data);


$data = $config->load('files/neonAdapter.neon', 'development');
Assert::same(array(
	'webname' => 'the example',
	'database' => array(
		'adapter' => 'pdo_mysql',
		'params' => array(
			'host' => 'dev.example.com',
			'username' => 'devuser',
			'password' => 'devsecret',
			'dbname' => 'dbname',
		),
	),
	'timeout' => 10,
	'display_errors' => TRUE,
	'html_errors' => FALSE,
	'items' => array(10, 20),
	'php' => array(
		'zlib.output_compression' => TRUE,
		'date.timezone' => 'Europe/Prague',
	),
), $data);


$config->save($data, TEMP_FILE);
Assert::match(<<<EOD
# generated by Nette

webname: the example
database:
	adapter: pdo_mysql
	params:
		host: dev.example.com
		username: devuser
		password: devsecret
		dbname: dbname


timeout: 10
display_errors: true
html_errors: false
items:
	- 10
	- 20

php:
	zlib.output_compression: true
	date.timezone: Europe/Prague
EOD
, file_get_contents(TEMP_FILE));


$data = $config->load('files/neonAdapter.neon');
$config->save($data, TEMP_FILE);
Assert::match(<<<EOD
# generated by Nette

production:
	webname: the example
	database:
		adapter: pdo_mysql
		params:
			host: db.example.com
			username: dbuser
			password: secret
			dbname: dbname



development < production:
	database:
		params:
			host: dev.example.com
			username: devuser
			password: devsecret


	timeout: 10
	display_errors: true
	html_errors: false
	items:
		- 10
		- 20

	php:
		zlib.output_compression: true
		date.timezone: Europe/Prague


nothing: null
EOD
, file_get_contents(TEMP_FILE));
