<?php
return [
	'default' => [
		'provider' => Kit\Glider\Platform\Mysqli\MysqliProvider::class,
		'host' => 'localhost',
		'alias' => 'mysqli',
		'username' => null,
		'password' => null,
		'database' => null,
		'charset' => 'utf8',
		'collation' => '',
		'domain' => null,
		'auto_commit' => false,
		'prefix' => '',
		'alt' => null
	],
	'pdo' => [
		'provider' => Kit\Glider\Platform\Pdo\PdoProvider::class,
		'host' => 'localhost',
		'alias' => 'pdo',
		'username' => null,
		'password' => null,
		'database' => null,
		'charset' => 'utf8',
		'collation' => 'utf8',
		'domain' => null,
		'prefix' => '',
		'auto_commit' => true,
		'alt' => null,
		'persistent' => true,
		'options' => [
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_CASE => PDO::CASE_NATURAL,
			PDO::ATTR_PERSISTENT => true
		]
	]
];