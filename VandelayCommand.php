<?php

class Vandelay extends WP_CLI_Command
{
	/**
	 * Exports configuration
	 * 
	 * ## OPTIONS
	 * 
	 * <config>
	 * : configuration options to export
	 *
	 * @synopsis <config>
	 */
	public function export($args)
	{
		$worker = $this->getWorker($args);
		$worker->export();
	}

	/**
	 * Imports configuration
	 * 
	 * ## OPTIONS
	 * 
	 * <config>
	 * : configuration options to import
	 *
	 * @synopsis <config>
	 */
	public function import($args)
	{
		$worker = $this->getWorker($args);
		$worker->import();
	}

	/**
	 * Get the worker object based on the
	 * arguments based to the main command
	 * @param  array $args  Arguments
	 * @return object 		Worker object
	 */
	protected function getWorker($args)
	{
		$worker = array_shift($args);
		$worker = "{$worker}_Worker";
		return new $worker;
	}
}

WP_CLI::add_command( "vandelay", "Vandelay" );