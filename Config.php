<?php
return [
	'default' => [
		'provider' => Glider\Connectors\Mysqli\Providers\MysqliProvider::class,
		'host' => 'localhost',
		'username' => 'root',
		'password' => 'root',
		'charset' => 'utf8',
		'collation' => 'utf8',
		'domain' => 'http://server.web/',
		'ext' => 'pdo'
	]
];