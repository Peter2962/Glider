<?php
ini_set('display_errors', 1);
// error_reporting(1);

use Glider\Schema\SchemaManager;
use Glider\Factory;

include 'Exceptions/ConnectionFailedException.php';
include 'ClassLoader.php';
include 'Result/Contract/ResultMapperContract.php';
include 'Result/Contract/PlatformResultContract.php';
include 'Result/ResultMapper.php';
include 'Result/Contract/CollectionContract.php';
include 'Result/Collection.php';
include 'Result/Mappers/DataResultMapper.php';
include 'Result/Exceptions/InvalidPropertyAccessException.php';
include 'Result/Exceptions/FunctionNotFoundException.php';
include 'Result/Platforms/MysqliResult.php';
include 'Processor/Contract/ProcessorProvider.php';
include 'Processor/AbstractProcessorProvider.php';
include 'Processor/Exceptions/QueryException.php';
include 'Statements/Contract/StatementContract.php';
include 'Statements/Platforms/MysqliStatement.php';
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
include 'Processor/Mysqli/MysqliProcessor.php';
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
include 'Schema/Expressions.php';
include 'Schema/Contract/SchemaManagerContract.php';
include 'Schema/SchemaManager.php';
include 'Factory.php';

$schema = Factory::getQueryBuilder();
$tables = $schema->select('*')->from('users')->get();

print '<pre>';
print_r($tables->all());