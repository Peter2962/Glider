<?php
namespace Glider\Query\Builder;

use Glider\Query\Builder\QueryBinder;
use Glider\Query\Builder\SqlGenerator;
use Glider\Connectors\Contract\ConnectorProvider;
use Glider\Query\Builder\Contract\QueryBuilderProvider;

class QueryBuilder implements QueryBuilderProvider
{

	/**
	* @var 		$connector
	* @access 	private
	*/
	private 	$connector;

	/**
	* @var 		$generator
	* @access 	private
	*/
	private 	$generator;

	/**
	* @var 		$bindings
	* @access 	protected
	*/
	protected 	$bindings = [];

	/**
	* {@inheritDoc}
	*/
	public function __construct(ConnectorProvider $connectorProvider)
	{
		$this->connector = $connectorProvider;
		$this->generator = new SqlGenerator();
	}

}