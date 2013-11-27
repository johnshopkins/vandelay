<?php

namespace vandelay\commands\sub;

class Options extends Command
{
	protected $config_file = "wp_options.json";

	protected $groups = array(
		"general" => array(
			"datetime" => array(
				"gmt_offset",
				"date_format",
				"start_of_week",
				"timezone_string",
				"time_format"
			),
			"environment" => array(
				"home",							// site url
				"siteurl" 						// wordpress address
			),
			"site_settings" => array(
				"admin_email",
				"blogdescription", 				// site tagline
				"blogname", 					// site title
				"blog_charset",					// charset blog is written/saved in; cannot set from dashboard
				"html_type"						// MIME type for blog pages - not editable in WP dashboard
			),
			"users" => array(
				"default_role",					// default role of people who register
				"users_can_register", 			// can users register? yes or no
				"wp_user_roles"					// array of user roles
			),
			"cron" => array(
				"cron"							// array containing the cron task schedule	
			)
		),

		"widgets" => array(
			"general" => array(
				"sidebars_widgets"				// an array of sidebar states (active and inactive widgets)
			),
			"wordpress" => array(
				"widget_archives",
				"widget_categories",
				"widget_meta",
				"widget_recent-comments",
				"widget_recent-posts",
				"widget_rss",
				"widget_search",
				"widget_text"
			),
			"dashboard" => array(
				"dashboard_widget_options"		// array containing settings of the widgets on the dashboard
			)
		),

		"discussion" => array(
			"comments" => array(
				"blacklist_keys", 				// keywords that if used in a comment will get it marked as spam. Also include IP addresses
				"close_comments_days_old", 		// number of days before comments close
				"close_comments_for_old_posts", // on/off
				"comments_notify", 				// attempt to notify any blogs linked to from the article
				"comments_per_page",
				"comment_max_links", 			// old a comment in queue if it has more than this many links
				"comment_moderation",
				"comment_order", 				// asc or desc
				"comment_registration", 		// whether user must be registered to comment
				"comment_whitelist", 			// comment author must have a previously approved comment to appear automatically
				"default_comments_page", 		// which page (first or last) should be displayed by default
				"default_comment_status", 		// whether comments are allowed by default
				"default_ping_status", 			// Allow notifications from other blogs
				"moderation_keys", 				// same as blacklist_keys except that the comment is only held for moderation
				"moderation_notify", 			// Email admin when comment is held for moderation
				"page_comments", 				// break comments into pages
				"require_name_email", 			// comment author must fill out name and email on/off
				"thread_comments",
				"thread_comments_depth",
				"use_trackback"
			),
			"avatars" => array(
				"avatar_default", 				// default avatar image
				"avatar_rating", 				// the maximum rating of avatars that are allowed to display
				"show_avatars" 					// avatars on/off
			)
		),

		"writing" => array(
			"general" => array(
				"default_category",			// ID of the category that posts will be put in automatically
				"ping_sites",
				"use_balanceTags",			// correct invalidly-nested XHTML automatically
				"use_smilies",				// convert emoticons
				"sticky_posts"				// array of posts IDs that are sticky posts
			),
			"viaemail" => array(
				"mailserver_login",
				"mailserver_pass",
				"mailserver_port",
				"mailserver_url",
				"default_email_category"	// ID of the category that posts will be put in when written via email
			)
		),

		"other" => array(
			"permalinks" => array(
				"category_base",			// in permalinks > optional section
				"permalink_structure",		// ex: /%year%/%postname%/
				"tag_base",					// in permalinks > optional section
			),
			"plugins" => array(
				"active_plugins", 			// array of active plugins and the main plugin file
				"uninstall_plugins"			// array of uninstallable plugins
			),
			"themes" => array(
				"stylesheet", 				// how WP knows how to find styles.css (same as template)
				"template", 				// the slug of the currently active theme
				"default_post_format"
			),
			"blogroll" => array(
				"links_recently_updated_append",
				"links_recently_updated_prepend",
				"links_recently_updated_time",
				"links_updated_date_format",
				"link_manager_enabled"
			),
			"media" => array(
				"large_size_h", 					// height of large image size
				"large_size_w", 					// width of large image size
				"medium_size_h", 					// height of medium image size
				"medium_size_w", 					// width of medium image size
				"thumbnail_crop", 					// on/off
				"thumbnail_size_h", 
				"thumbnail_size_w",
				"uploads_use_yearmonth_folders", 	// Organize upload yes/no
				"upload_path",						// Supposed to store upload path, yet nothing is here
				"upload_url_path",					// URL path to the upload folder, yet nothing is here
				"image_default_align",
				"image_default_link_type",
				"image_default_size"
			),

			

			"reading" => array(
				"blog_public",						// whether or not your blog is accessible by search engines
				"default_pingback_flag",			// whether sites you link to are pinged when you publish an article -- depends on blog_public
				"posts_per_page",
				"posts_per_rss",
				"rss_use_excerpt",
				"show_on_front",					// what to show on the front page -- page or posts
				"page_on_front",	 				// "Front page"	the id of the page that should be displayed on the front page
				"page_for_posts"	 				// "Posts page"	id of the page that displays posts. Useful when the fronpage displays posts (show_on_front = page)
			),
		)
	);
	
	/**
	 * Find out which groups of WordPress options
	 * were selected for import/export in the admin
	 * @return array
	 */
	protected function getSelectedGroups()
	{
		global $wpdb;
		$options = $wpdb->get_results("SELECT option_name, option_value FROM wp_options WHERE option_name LIKE 'vandelay_wp_options_%'", ARRAY_A);
		
		$selected = array();

		foreach ($options as $option) {
			$group = str_replace("vandelay_wp_options_", "", $option["option_name"]);
			$value = maybe_unserialize($option["option_value"]);
			$selected[$group] = is_array($value) ? array_keys($value) : array();
		}

		return $selected;
	}

	/**
	 * Find out which WordPress options need to be
	 * imported/exported
	 * @return array
	 */
	protected function getSelectedOptions()
	{
		global $wpdb;
		
		$groups = $this->getSelectedGroups();
		$options = array();

		foreach ($groups as $group => $keys) {
			foreach ($keys as $key) {
				$options = array_merge($options, $this->groups[$group][$key]);
			}
		}

		return $options;
	}

	/**
	 * Exports ACF field groups from database to file.
	 * @return null
	 */
	public function export()
	{
		global $wpdb;

		$options = $this->getSelectedOptions();

		if (!$options) {
			\WP_CLI::warning("No options are selected for import/export. Go to Settings > Vandelay to select options for import/export.");
			return;
		}

		// stringify the option keys
		$keys = array_map(function ($v) {
			return "'{$v}'";
		}, $options);

		$keys = implode(",", $keys);

		$options = $wpdb->get_results("SELECT * FROM wp_options WHERE option_name IN ({$keys})", ARRAY_A);

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
		// $options = $this->getSelectedOptions();
		$data = $this->readConfig();
		foreach ($data as $k => $v) {
			// if (in_array($k, $options)) {
				update_option($k, $v);
			// }
		}
		\WP_CLI::success("WordPress options successfully imported.");
	}
	
}