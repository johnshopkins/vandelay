<?php

namespace vandelay\commands\sub;

class Command
{
	/**
	 * Directory in which configuration
	 * files will be stored
	 * @var string
	 */
	protected $config_dir;

	/**
	 * Created in child classes. File in which
	 * configuration will be saved.
	 * @var string
	 */
	protected $config_file;

	public function __construct()
	{
		$this->config_dir = "/var/www/htmnl/jhu.edu/config/wordpress/";
	}

	/**
	 * Get the path of a configuration file
	 * based on the app name.
	 * @param  string $app Name of app
	 * @return string File path
	 */
	protected function getFilePath()
	{
		if (empty($this->config_file)) {
			\WP_CLI::error("A configuration file for this action has not been set.");
		}

		return $this->config_dir . $this->config_file;
	}

	/**
	 * Save configuration to a file
	 * @param  array $data Array of data
	 * @return null
	 */
	protected function saveConfig($data)
	{
		$put = file_put_contents($this->getFilePath(), json_encode($data, JSON_PRETTY_PRINT));

		if ($put) {
			\WP_CLI::success("Settings were successfully exported.");
		} else {
			\WP_CLI::error("Something went wrong while trying to write to the config file. Please make sure `{$this->config_dir}` is writable by WP CLI.");
		}
	}

	/**
	 * Read the configuration
	 * from a file.
	 * @return array  Array of data
	 */
	protected function readConfig()
	{
		$file = $this->getFilePath();

		if (file_exists($file)) {
			$data = file_get_contents($file);
			return json_decode($data, true);
		} else {
			\WP_CLI::error("You must export settings before you can import them.");
		}
	}
}