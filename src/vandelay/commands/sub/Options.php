<?php

namespace vandelay\commands\sub;

class Options extends Command
{
	protected $config_file = "wp_options.json";

	/**
	 * Exports ACF field groups from database to file.
	 * @return null
	 */
	public function export()
	{
		global $wpdb;

		$options = $wpdb->get_results("SELECT * FROM wp_options WHERE option_name NOT LIKE '_transient_%' AND option_name NOT LIKE '_site_transient_%'", ARRAY_A);
		$options = array_map(function($v) {
			$v["option_value"] = maybe_unserialize($v["option_value"]);
			return $v;
		}, $options);

		$options = array_column($options, "option_value", "option_name");

		$this->saveConfig($options);
	}

	/**
	 * Imports ACF field groups from file to database
	 * @return null
	 */
	public function import()
	{
		$data = $this->readConfig();
		foreach ($data as $k => $v) {
			update_option($k, $v);
		}
		\WP_CLI::success("WordPress options successfully imported.");
	}
	
}