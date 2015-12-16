<?php

namespace vandelay\commands;

use WP_CLI;

class Vandelay extends \WP_CLI_Command
{
	public function __construct()
	{
		parent::__construct();

		if (!defined("VANDELAY_CONFIG_FILE")) {
			WP_CLI::error("Please set configuration file using VANDELAY_CONFIG_FILE constant");
		}

		// include ACF file needed for import/export
		acf_include("admin/settings-tools.php");
		$this->tools = new \acf_settings_tools();
	}

	/**
	 * Use an ACF function to export field groups
	 * @return null
	 */
	public function export()
	{
		// create post variable for ACF function
		$_POST["acf_export_keys"] = $this->getFieldGroupNames();

		$data = $this->tools->get_json();
		$this->saveConfig($data);
	}

	/**
	 * Imports ACF field groups from file to database
	 * @return null
	 */
	public function import()
	{
		// create files variable for ACF function
		$_FILES = array(
			"acf_import_file" => array(
				"name" => VANDELAY_CONFIG_FILE,
				"tmp_name" => VANDELAY_CONFIG_FILE,
				"error" => false
			)
		);

		$this->tools->import();
	}

	protected function getFieldGroupNames()
	{
		$posts = get_posts(array(
			"posts_per_page" => -1,
			"post_type" => "acf-field-group",
			"post_status" => "publish"
		));

		return array_map(function ($post) {
			return $post->post_name;
		}, $posts);
	}

	/**
	 * Save configuration to a file
	 * @param  array $data Array of data
	 * @return null
	 */
	protected function saveConfig($data)
	{
		$put = file_put_contents(VANDELAY_CONFIG_FILE, json_encode($data, JSON_PRETTY_PRINT));

		if ($put) {
			\WP_CLI::success("Settings were successfully exported.");
		} else {
			\WP_CLI::error("Something went wrong while trying to write to the config file. Please make sure `{VANDELAY_CONFIG_DIR}` is writable by WP CLI.");
		}
	}
}
