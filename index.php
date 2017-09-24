<?php
ini_set('display_errors', 1);

include 'ClassLoader.php';
include 'Connection/ConnectionLoader.php';
include 'Contract/ConfiguratorInterface.php';
include 'Connectors/Contract/ConnectorProviderInterface.php';
include 'Connection/Domain.php';
include 'Connection/Connector.php';
include 'Platform/Contract/PlatformProvider.php';
include 'Platform/Mysqli/MysqliProvider.php';
include 'Connectors/Mysqli/MysqliConnector.php';
include 'Connection/Contract/ConnectionInterface.php';
include 'Connection/QueuedConnections.php';
include 'Connection/ConnectionManager.php';

$db = (new Glider\Connection\ConnectionManager())->getConnection();