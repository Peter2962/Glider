<?php
ini_set('display_errors', 1);
// error_reporting(1);

include 'Exceptions/ConnectionFailedException.php';
include 'ClassLoader.php';
include 'Result/Contract/ResultMapperContract.php';
include 'Result/ResultMapper.php';
include 'Result/Mappers/DataResultMapper.php';
include 'Result/Exceptions/InvalidPropertyAccessException.php';
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
$queryBuilder = $db->getQueryBuilder();
$result = $queryBuilder->select('*')
->from('users')
->where('id', 14)
->orderByField(['id', 'firstname'], 'FIELD');

print '<pre>';
print_r($result->getResult());