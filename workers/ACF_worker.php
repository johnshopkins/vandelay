<?php

class acf_Worker extends Worker
{
	protected $config_file = "advanced_custom_forms.json";

	/**
	 * Exports ACF field groups from database to file.
	 * @return null
	 */
	public function export()
	{
		$this->deleteAcfAutoDrafts();

		$saveConfig = array();
		foreach ($this->getFieldGroups() as $post) {
			$saveConfig[] = array(
				"post" => get_object_vars($post),
				"meta" => $this->getPostMeta($post->ID)
			);
		}

		$this->saveConfig($saveConfig);
	}

	/**
	 * Imports ACF field groups from file to database
	 * @return null
	 */
	public function import()
	{
		// get rid of any ACF field groups that are not published - if an unpublished
		// ACF field group has the same name as one we're trying to import, it will fail
		$this->deleteUnpublished();
		
		$data = $this->readConfig();
		$fieldGroupsInFile = array();

		foreach ($data as $post) {

			$fromFile = $post;
			$fromDb = $this->getPost($fromFile["post"]["post_name"]);

			$fieldGroupsInFile[] = $fromFile["post"]["post_name"];

			if (is_null($fromDb["post"])) {
				WP_CLI::warning("Group `{$fromFile['post']['post_title']}` does not exist in the database, created.");
				$this->createFieldGroup($fromFile["post"], $fromFile["meta"]);
				continue;
			}

			if ($fromDb["post"]["post_modified_gmt"] !== $fromFile["post"]["post_modified_gmt"]) {
				WP_CLI::warning("Group `{$fromFile['post']['post_title']}` changed since last import, updating.");
				$this->updateFieldGroup($fromDb["post"]["ID"], $fromDb["meta"], $fromFile["post"], $fromFile["meta"]);
				continue;
			}

			WP_CLI::warning("Group `{$fromFile['post']['post_title']}` did not change since last import, skipping.");

		}

		$this->deleteGroupsNotInFile($fieldGroupsInFile);	

		WP_CLI::success("ACF field groups successfully imported.");
	}
	
	/**
	 * Retrieve advanced custom forms
	 * field groups from the database.
	 * @return array Field group posts
	 */
	protected function getFieldGroups()
	{
		return get_posts(array(
			"posts_per_page" => -1,
			"post_type" => "acf",
			"post_status" => "publish"
		));
	}

	/**
	 * Get an ACF field group by its name. ACF
	 * makes sure the post name of each field
	 * group is unique.
	 * @param  string $name Name of field group
	 * @return object Post object
	 */
	protected function getFieldGroupByName($name)
	{
		$posts = get_posts(array(
			"post_type" => "acf",
			"posts_per_page" => 1,
			"name" => $name 
		));
		return array_shift($posts);
	}

	/**
	 * Get the complete post (post and meta) information
	 * from the database based on the name of the post.
	 * @param  [type] $name [description]
	 * @return [type]       [description]
	 */
	protected function getPost($name)
	{
		if (!$post = $this->getFieldGroupByName($name)) {
			return null;
		}

		$post = get_object_vars($post);
		$meta = $this->getPostMeta($post["ID"]);

		return array(
			"post" => $post,
			"meta" => $meta
		);
	}
	
	/**
	 * Return meta data from a given post
	 * @param  obejct $post Post object
	 * @return array Meta data
	 */
	protected function getPostMeta($id)
	{
		$meta = get_post_meta($id);
		
		$meta = array_map(function($value) {

			if (count($value) > 1) {
				return array_map(function($v) {
					return maybe_unserialize($v);
				}, $value);
			} else {
				return maybe_unserialize($value[0]);
			}

		}, $meta);

		// handle 'rule' differently
		$rule = get_post_meta($id, "rule");
		if ($rule) {
			$meta["rule"] = array_map(function($v) {
				return maybe_unserialize($v);
			}, $rule);
		}

		return $meta;
	}

	/**
	 * Some ACF meta is stored with duplicate meta keys instead
	 * of as an array on a single key, so we need to delete all
	 * meta with that key and then add them back one-by-one.
	 * @param int    $id     ID of post to update
	 * @param string $key    Meta key
	 * @param array  $value  Array of values
	 */
	protected function createDuplicateMetaKeys($id, $key, $value)
	{
		delete_post_meta($id, $key);
		foreach ($value as $v) {
			add_post_meta($id, $key, $v);
		}
	}

	/**
	 * Delete auto drafts
	 * @return null
	 */
	protected function deleteAcfAutoDrafts()
	{
		global $wpdb;
		$wpdb->delete("wp_posts", array(
			"post_type" => "acf",
			"post_status" => "auto-draft",
			"post_date_gmt" => "0000-00-00 00:00:00"
		));
	}

	/**
	 * Delete the unpublished ACF field groups so that upon
	 * import, unpublished field groups do not interfere with
	 * the import.
	 * @return null
	 */
	protected function deleteUnpublished()
	{
		global $wpdb;
		$wpdb->query("DELETE FROM wp_posts WHERE post_type = 'acf' AND post_status != 'publish';");
	}

	/**
	 * Delete the field groups present in the database, but
	 * not present in the passed array.
	 * @param  array $groupsInFile Names of groups
	 * @return null
	 */
	protected function deleteGroupsNotInFile($groupsInFile)
	{
		$fieldGroupsInDb = array_map(function($v) {
			return $v->post_name;
		}, $this->getFieldGroups());

		$diff = array_diff($fieldGroupsInDb, $groupsInFile);
		foreach ($diff as $name) {
			$this->deleteFieldGroupByName($name);
		}
	}

	protected function deleteFieldGroupByName($name)
	{
		global $wpdb;
		$wpdb->delete("wp_posts", array(
			"post_type" => "acf",
			"post_name" => $name 
		));
	}

	/**
	 * Create a new field group
	 * @param  array $post Post data of new field group
	 * @param  array $meta Meta data of new field group
	 * @return null
	 */
	protected function createFieldGroup($post, $meta)
	{
		unset($post["ID"]); // we're creating a NEW post based on a post
		$newpost = wp_insert_post($post);

		$this->updateMeta($newpost, $meta);
		$this->updateModifiedDate($newpost, $post);
	}

	/**
	 * Update a post in the database with the given post and meta data
	 * @param  int    $id      Post ID to update in database
	 * @param  array  $newpost Array of new post data
	 * @param  array  $dbMeta  Array of old meta data to compare new against
	 * @param  array  $newmeta Array of new meta data
	 * @return null
	 */
	protected function updateFieldGroup($id, $dbMeta, $newpost, $newmeta)
	{
		$newpost["ID"] = $id;
		$update = wp_update_post($newpost);

		$this->updateMeta($id, $newmeta);

		// get rid of meta that is in the database, but not in the config
		$diff = array_diff_key($dbMeta, $newmeta);
		foreach ($diff as $k => $v) {
			$test = delete_post_meta($id, $k);
		}

		// set the modified date to the date found in the config
		$this->updateModifiedDate($id, $newpost);
	}
	
	/**
	 * Update the meta data of a post
	 * @param  int   $id   ID of post to update
	 * @param  array $meta Array of meta data to attach to the psot
	 * @return null
	 */
	protected function updateMeta($id, $meta)
	{
		foreach ($meta as $k => $v) {
			if ($k == "rule") {
				$this->createDuplicateMetaKeys($id, $k, $v);
			} else {
				update_post_meta($id, $k, $v);
			}
		}
	}

	/**
	 * Updates the modified date of a post.
	 * 
	 * When a post is created or updated, WordPress updates the post's
	 * modified date based when it creates or updates the post. Vandelay
	 * tracks changes based on the modified date, so it must be
	 * changed to the date found in the configuration.
	 * 
	 * @param  int 		$id            	ID of new post
	 * @param  object 	$postDataToUse 	Post data to use
	 * @return null
	 */
	protected function updateModifiedDate($id, $postDataToUse)
	{
		global $wpdb;
		$update = $wpdb->update("wp_posts",
			array(
				"post_modified" => $postDataToUse["post_modified"],
				"post_modified_gmt" => $postDataToUse["post_modified_gmt"]
			),
			array(
				"ID" => $id
			)
		);
	}
}