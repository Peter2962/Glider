<?php
ini_set('display_errors', 1);

include 'Exceptions/ConnectionFailedException.php';
include 'ClassLoader.php';
include 'Statements/Contract/StatementProvider.php';
include 'Statements/AbstractStatementProvider.php';
include 'Statements/Exceptions/QueryException.php';
include 'Events/Contract/Subscriber.php';
include 'Query/Builder/Type.php';
include 'Query/Builder/SqlGenerator.php';
include 'Query/Builder/QueryBinder.php';
include 'Query/Builder/Contract/QueryBuilderProvider.php';
include 'Query/Builder/QueryBuilder.php';
include 'Query/Exceptions/InvalidParameterCountException.php';
include 'Query/Exceptions/ParameterNotFoundException.php';
include 'Query/Parameters.php';
include 'Transactions/Contract/TransactionProvider.php';
include 'Transactions/Mysqli/MysqliTransaction.php';
include 'Statements/Mysqli/MysqliStatement.php';
include 'Events/Subscribers/ConnectionAttemptSubscriber.php';
include 'Events/Subscribers/BuildEventsSubscriber.php';
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
$builder = $db->getQueryBuilder()
->rawQuery('SELECT * FROM users WHERE firstname = :name AND id = :id')
->setParam('name', 'Peter');

$result = $builder->getResult();
// $d = new mysqli('localhost', 'root', 'root', 'service_finder_app');
// $a = $d->query('SELECT * FROM users');


// foreach($a as $b) {
// 	print_r($b);
// }

// print '<pre>';
// print_r($a);