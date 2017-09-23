<?php
ini_set('display_errors', 1);

include 'ClassLoader.php';
include 'Connection/ConnectionLoader.php';
include 'Contract/ConfiguratorInterface.php';
include 'Connection/Connector.php';
include 'Connection/Contract/ConnectionInterface.php';
include 'Connection/QueuedConnections.php';
include 'Connection/ConnectionManager.php';

$db = (new Glider\Connection\ConnectionManager())->getConnection();