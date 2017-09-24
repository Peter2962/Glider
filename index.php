<?php
ini_set('display_errors', 1);

include 'Exceptions/ConnectionFailedException.php';
include 'ClassLoader.php';
include 'Events/Contract/Subscriber.php';
include 'Events/Subscribers/ConnectionAttemptSubscriber.php';
include 'Events/EventManager.php';
include 'Connection/ConnectionLoader.php';
include 'Contract/ConfiguratorInterface.php';
include 'Connectors/Contract/ConnectorProvider.php';
include 'Connection/Domain.php';
include 'Connection/PlatformResolver.php';
include 'Platform/Contract/PlatformProvider.php';
include 'Platform/Mysqli/MysqliProvider.php';
include 'Connectors/Mysqli/MysqliConnector.php';
include 'Connection/Contract/ConnectionInterface.php';
include 'Connection/QueuedConnections.php';
include 'Connection/ConnectionManager.php';
include 'Factory.php';

$db = new Glider\Factory();