<?php
ini_set('display_errors', 1);
// error_reporting(1);

use Glider\Schema\SchemaManager;
use Glider\Schema\Scheme;
use Glider\Factory;

function pre($a) {
	print '<pre>';
	print_r($a);
}

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
include 'Schema/Scheme.php';
include 'Schema/Platforms/MysqliSchemaManager.php';
include 'Schema/Contract/BaseTableContract.php';
include 'Schema/Column/Type/Contract/TypeContract.php';
include 'Schema/Column/Type/Varchar.php';
include 'Schema/Column/Type/Char.php';
include 'Schema/Column/Type/Integer.php';
include 'Schema/Column/Type/Bit.php';
include 'Schema/Column/Type/TinyInt.php';
include 'Schema/Column/Type/BigInt.php';
include 'Schema/Column/Type/Decimal.php';
include 'Schema/Column/Type/Double.php';
include 'Schema/Column/Type/Text.php';
include 'Schema/Column/Type/TinyText.php';
include 'Schema/Column/Type/MediumText.php';
include 'Schema/Column/Type/LongText.php';
include 'Schema/Column/Type/Blob.php';
include 'Schema/Column/Type/MediumBlob.php';
include 'Schema/Column/Type/LongBlob.php';
include 'Schema/Column.php';
include 'Schema/Table.php';
include 'Factory.php';

// $schema = Factory::getSchema();
$table = SchemaManager::table('users');

$name = 'Name';
$age = 19;
$scheme = new Scheme();

$table->create(function(Scheme $scheme) {
	$scheme->integer('id', 11, false, true, true);
	$scheme->varchar('name', 50, true);
	$scheme->char('age', 35, true);
	$scheme->bit('_val', 11, true);
	$scheme->tinyint('admin', 11, true);
	$scheme->bigint('active', 11, true);
	$scheme->decimal('decimmm', [11, 0], true);
	$scheme->double('flooaaaaat', [31, 30], true);
	$scheme->text('txt', null, true);
	$scheme->tinytext('tytxt', null, true);
	$scheme->mediumtext('medtxt', null, true);
	$scheme->longtext('longtxt', null, true);
	$scheme->blob('blb', null, true);
	$scheme->mediumblob('medblb', null, true);
	$scheme->longblob('lngblb', null, true);
});