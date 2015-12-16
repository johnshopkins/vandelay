<?php

namespace vandelay\commands;

class Vandelay extends \WP_CLI_Command
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
		$subcommand = $this->getsubcommand($args);
		$subcommand->export();
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
		$subcommand = $this->getsubcommand($args);
		$subcommand->import();
	}

	/**
	 * Get the subcommand object based on the
	 * arguments based to the main command
	 * @param  array $args  Arguments
	 * @return object 		subcommand object
	 */
	protected function getsubcommand($args)
	{
		$subcommand = ucfirst(array_shift($args));
		$subcommand = "\\vandelay\\commands\\sub\\{$subcommand}";
		return new $subcommand;
	}
}