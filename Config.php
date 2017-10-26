<?php
return [
	'default' => [
		'provider' => Glider\Platform\Mysqli\MysqliProvider::class,
		'host' => 'localhost',
		'alias' => 'mysqli',
		'username' => 'root',
		'password' => '',
		'database' => 'project',
		'charset' => 'utf8',
		'collation' => '',
		'domain' => 'localhost',
		'auto_commit' => false,
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
		'auto_commit' => true,
		'alt' => null
	]
];