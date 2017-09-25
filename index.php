<?php
include 'Exceptions/ConnectionFailedException.php';
include 'ClassLoader.php';
include 'Events/Contract/Subscriber.php';
include 'Query/Builder/SqlGenerator.php';
include 'Query/Builder/QueryBinder.php';
include 'Query/Builder/Contract/QueryBuilderProvider.php';
include 'Query/Builder/QueryBuilder.php';
include 'Transactions/Contract/TransactionProvider.php';
include 'Transactions/Mysqli/MysqliTransaction.php';
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

print '<pre>';
print_r($db->getQueryBuilder());