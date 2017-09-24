<?php
return [
	'default' => [
		'provider' => Glider\Platform\Mysqli\MysqliProvider::class,
		'host' => 'localhost',
		'username' => 'root',
		'password' => 'root',
		'charset' => 'utf8',
		'collation' => 'utf8',
		'domain' => 'localhost',
		'prefix' => '',
		'alt' => 'dev'
	],
	'dev' => [
		'provider' => Glider\Platform\Pdo\PdoProvider::class,
		'host' => 'localhost',
		'username' => 'root',
		'password' => 'root',
		'charset' => 'utf8',
		'collation' => 'utf8',
		'domain' => 'http://server.web/',
		'prefix' => '',
		'alt' => null
	]
];