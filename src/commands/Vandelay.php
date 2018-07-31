<?php

namespace vandelay\commands;

use WP_CLI;

class Vandelay extends \WP_CLI_Command
{
  public function __construct()
  {
    acf_include('includes/admin/admin-tools.php');
    acf_include('includes/admin/tools/class-acf-admin-tool.php');
  }

  public function getFileLocation()
  {
    return get_template_directory() . '/config/acf.json';
  }

	/**
	 * Use an ACF function to export field groups
	 * @return null
	 */
	public function export($args)
	{
    if (is_multisite()) {
      if (empty($args)) {
        \WP_CLI::error('Please specify a blog ID');
      }
      switch_to_blog($args[0]);
    }

		// disable filters (default to raw data)
		acf_disable_filters();

		// include ACF file needed for export
    acf_include('includes/admin/tools/class-acf-admin-tool-export.php');
		$exporter = new \ACF_Admin_Tool_Export();

		// create post variable for ACF function
		$_POST['keys'] = $this->getFieldGroupNames();

		$data = $exporter->get_selected();

		$this->saveConfig($data, $this->getFileLocation());

    restore_current_blog();
	}

	/**
	 * Imports ACF field groups from file to database
	 * @return null
	 */
	public function import($args)
	{
    if (is_multisite()) {
      if (empty($args)) {
        \WP_CLI::error('Please specify a blog ID');
      }
      switch_to_blog($args[0]);
    }

    // acf_include('includes/admin/tools/class-acf-admin-tool-import.php');

		$this->importFields();

    restore_current_blog();
	}

	/*
	*  getFields
	*
	*  Gets all acf-field-group posts from the database
	*
	*  @type	function
	*  @date	12/16/2015
	*
	*  @param	n/a
	*  @return	n/a
	*/
	function getFieldGroups() {
		$posts = get_posts(array(
			"posts_per_page" => -1,
			"post_type" => "acf-field-group",
			"post_status" => "any"
		));

		$return = array();

		foreach ($posts as $post) {
			$return[$post->ID] = $post;
		}

		return $return;
	}

	/*
	*  getFields
	*
	*  Gets all acf-field posts from the database
	*
	*  @type	function
	*  @date	12/16/2015
	*
	*  @param	n/a
	*  @return	n/a
	*/
	function getFields() {
		$posts = get_posts(array(
			"posts_per_page" => -1,
			"post_type" => "acf-field",
			"post_status" => "any"
		));

		$return = array();

		foreach ($posts as $post) {
			$return[$post->ID] = $post;
		}

		return $return;
	}

	/**
	 * An altered version of acf/admin/settings-tool.php::import()
	 *
	 * ACF's import function takes care of most things, but this
	 * function makes up for what it lacks:
	 *
	 * - Removes fields that are in the DB, but not in the import file
	 * - Removes field groups that are in the DB, but not in the import file
	 * - Updates fields that have changed
	 * - Displays command-line messages
	 *
	 * @return null
	 */
	protected function importFields() {

		// read file
		$json = file_get_contents($this->getFileLocation());


		// decode json
		$json = json_decode($json, true);


  	// vars
  	$ref = [];
  	$order = [];

    // all groups and fields curerntly in the db
  	$allgroups = $this->getFieldGroups();
  	$allfields = $this->getFields();

  	foreach( $json as $field_group ) {

			$update = false;

    	// check if field group exists
    	if ($post = _acf_get_field_group_by_key($field_group['key'])) {

				// add ID to trigger update instead of insert
				$field_group['ID'] = $post['ID'];

				$update = true;
			} else {
        $field_group['ID'] = null;
      }

      if (defined(ENV) && ENV === 'local') {
        // turn of lower-errors while ACF functions run (they throw notices)
        $current = error_reporting();
        error_reporting('E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED');
      }

			// save field group
			$field_group = acf_import_field_group($field_group);

      if (defined(ENV) && ENV === 'local') {
        error_reporting($current);
      }

			if ($update) {
				\WP_CLI::success($field_group['title'] . " field group updated.");
			} else {
				\WP_CLI::success($field_group['title'] . " field group added.");
			}

  	}
	}

	protected function getFieldGroupNames()
	{
		$posts = get_posts(array(
			"posts_per_page" => -1,
			"post_type" => "acf-field-group",
			"post_status" => "any"
		));

		return array_map(function ($post) {
			return $post->post_name;
		}, $posts);
	}

	/**
	 * Save configuration to a file
	 * @param  array  $data      Array of data
	 * @param  string $location  File location
	 * @return null
	 */
	protected function saveConfig($data, $location)
	{
		$put = file_put_contents($location, json_encode($data, JSON_PRETTY_PRINT));

		if ($put) {
			\WP_CLI::success("ACF settings were successfully exported.");
		} else {
			\WP_CLI::error("Something went wrong while trying to write to the config file. Please make sure " . $location . " is writable by WP CLI.");
		}
	}
}
