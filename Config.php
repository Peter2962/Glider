<?php
return [
	'default' => [
		'provider' => Glider\Platform\Mysqli\MysqliProvider::class,
		'host' => 'localhost',
		'alias' => 'mysqli',
		'username' => 'root',
		'password' => 'root',
		'database' => 'test',
		'charset' => 'utf8',
		'collation' => '',
		'domain' => 'glider.app',
		'prefix' => '',
		'alt' => 'dev'
	],
	'dev' => [
		'provider' => Glider\Platform\Pdo\PdoProvider::class,
		'host' => 'localhost',
		'alias' => 'pdo',
		'username' => 'root',
		'password' => 'root',
		'database' => 'test',
		'charset' => 'utf8',
		'collation' => 'utf8',
		'domain' => 'http://server.web/',
		'prefix' => '',
		'alt' => null
	]
];