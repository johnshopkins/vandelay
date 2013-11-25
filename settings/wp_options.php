<?php

$sections = array(

	"general" => array(
		"nicename" => "General",
		"content" => "<p>HELLO</p>",
		"sections" => array(
			"datetime" => array(
				"nicename" => "Date/Time",
				"keys" => array(
					"gmt_offset",
					"date_format",
					"start_of_week",
					"timezone_string",
					"time_format"
				)
			),
			"environment" => array(
				"nicename" => "Environment",
				"keys" => array(
					"home",							// site url
					"siteurl" 						// wordpress address
				)
			),
			"site" => array(
				"nicename" => "Site",
				"keys" => array(
					"admin_email",
					"blogdescription", 				// site tagline
					"blogname", 					// site title
					"blog_charset",					// charset blog is written/saved in; cannot set from dashboard
					"html_type"						// MIME type for blog pages - not editable in WP dashboard
				)
			),
			"users" => array(
				"nicename" => "Users",
				"keys" => array(
					"default_role",					// default role of people who register
					"users_can_register", 			// can users register? yes or no
					"wp_user_roles"					// array of user roles
				)
			),
			"cron" => array(
				"nicename" => "Cron",
				"keys" => array(
					"cron"							// array containing the cron task schedule	
				)
			)
		)
	),


	"plugins" => array(
		"nicename" => "Plugins",
		"keys" => array(
			"active_plugins", 						// array of active plugins and the main plugin file
			"uninstall_plugins"						// array of uninstallable plugins
		)
	),


	"themes" => array(
		"nicename" => "Themes",
		"keys" => array(
			"stylesheet", 							// how WP knows how to find styles.css (same as template)
			"template", 							// the slug of the currently active theme
			"default_post_format"
		)
	),

	"widgets" => array(
		"nicename" => "Widgets",
		"sections" => array(
			"general" => array(
				"nicename" => "General",
				"keys" => array(
					"sidebars_widgets"				// an array of sidebar states (active and inactive widgets)
				)
			),
			"wordpress" => array(
				"nicename" => "WordPress",
				"keys" => array(
					"widget_archives",
					"widget_categories",
					"widget_meta",
					"widget_recent-comments",
					"widget_recent-posts",
					"widget_rss",
					"widget_search",
					"widget_text"
				)
			),
			"dashboard" => array(
				"nicename" => "Dashboard",
				"keys" => array(
					"dashboard_widget_options"		// array containing settings of the widgets on the dashboard
				)
			)
		)
	),


	"discussion" => array(
		"nicename" => "Discussion",
		"sections" => array(
			"comments" => array(
				"nicename" => "Comments",
				"keys" => array(
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
				)
			),
			"avatars" => array(
				"nicename" => "Avatars",
				"keys" => array(
					"avatar_default", 				// default avatar image
					"avatar_rating", 				// the maximum rating of avatars that are allowed to display
					"show_avatars" 					// avatars on/off
				)
			)
		)
	),

	"media" => array(
		"nicename" => "Media",
		"keys" => array(
			"large_size_h", 						// height of large image size
			"large_size_w", 						// width of large image size
			"medium_size_h", 						// height of medium image size
			"medium_size_w", 						// width of medium image size
			"thumbnail_crop", 						// on/off
			"thumbnail_size_h", 
			"thumbnail_size_w",
			"uploads_use_yearmonth_folders", 		// Organize upload yes/no
			"upload_path",							// Supposed to store upload path, yet nothing is here
			"upload_url_path",						// URL path to the upload folder, yet nothing is here
			"image_default_align",
			"image_default_link_type",
			"image_default_size"
		)
	),

	"permalinks" => array(
		"nicename" => "Permalinks",
		"keys" => array(
			"category_base",						// in permalinks > optional section
			"permalink_structure",					// ex: /%year%/%postname%/
			"tag_base",								// in permalinks > optional section
		)
	),

	"reading" => array(
		"nicename" => "Reading",
		"keys" => array(
			"blog_public",							// whether or not your blog is accessible by search engines
			"default_pingback_flag",				// whether sites you link to are pinged when you publish an article -- depends on blog_public
			"posts_per_page",
			"posts_per_rss",
			"rss_use_excerpt",
			"show_on_front",						// what to show on the front page -- page or posts
			"page_on_front",	 					// "Front page"	the id of the page that should be displayed on the front page
			"page_for_posts"	 					// "Posts page"	id of the page that displays posts. Useful when the fronpage displays posts (show_on_front = page)
		)
	),

	"writing" => array(
		"nicename" => "Writing",
		"sections" => array(
			"general" => array(
				"nicename" => "General",
				"keys" => array(
					"default_category",				// ID of the category that posts will be put in automatically
					"ping_sites",
					"use_balanceTags",				// correct invalidly-nested XHTML automatically
					"use_smilies",					// convert emoticons
					"sticky_posts"					// array of posts IDs that are sticky posts
				)
			),
			"viaemail" => array(
				"nicename" => "Post via Email",
				"keys" => array(
					"mailserver_login",
					"mailserver_pass",
					"mailserver_port",
					"mailserver_url",
					"default_email_category"		// ID of the category that posts will be put in when written via email
				)
			)
		)
	),

	"blogroll" => array(
		"nicename" => "Blogroll",
		"keys" => array(
			"links_recently_updated_append",
			"links_recently_updated_prepend",
			"links_recently_updated_time",
			"links_updated_date_format",
			"link_manager_enabled"
		)

	)


	// plugin specific
	// "acf_version",
	// "p2p_storage"

);








add_action("admin_init", "vandelay_wp_options");
function vandelay_wp_options()
{
	global $sections;

	// create "WordPress Options" section
	add_settings_section(
		"valdelay_wp_options_settings_section", 		// section's unique ID
		"WordPress Options",							// section title
		"vandelay_wp_options_intro",					// to create content in the section
		"vandelay"										// page to add this section to
	);

	
	foreach ($sections as $section => $details) {

		if (isset($details["sections"])) {

			vandelay_create_field($section, $details["nicename"], "valdelay_wp_options_settings_section", $details["sections"]);

			// foreach ($details["sections"] as $subsection => $details) {
			// 	// vandelay_create_field($subsection, $details["nicename"], "valdelay_wp_options_settings_section");
			// }
		} elseif (isset($details["keys"])) {
			// vandelay_create_field($section, $details["nicename"], "valdelay_wp_options_settings_section");
		}
	} 
}


function vandelay_wp_options_intro()
{
	echo "<p>Decide which groups of WordPress options to export.</p>";
}

function vandelay_create_field($machinename, $title, $section, $fields = null)
{
	add_settings_field(   
	    "vandelay_setting_{$machinename}",			// field's unique ID
	    $title,										// Generl settings
	    "valdelay_print_check",						// function that renders the option UI
	    "vandelay",									// page to add this field to
	    $section,									// section to add this fiel to
	    array(										// array of arguments to pass to the callback. 
	        $machinename, $title, $fields  
	    )  
	);

	register_setting("vandelay", "vandelay_setting_{$machinename}");  
}


function vandelay_wp_options_setting_content()
{
	echo "<p>Configure which options to export.</p>";
}

function valdelay_print_check($args)
{  
	$machinename = $args[0];
	$label = $args[1];
	$fields = isset($args[2]) ? $args[2] : null;
	$html = "";

	if ($fields) {

		foreach ($fields as $k => $v) {
			$fieldname = "vandelay_{$machinename}[$k]";
			$html .= "<input type=\"checkbox\" id=\"\" name=\"{$fieldname}\" value=\"1\" " . checked(1, get_option($fieldname, false)) . "> <label for=\"{$fieldname}\">{$v['nicename']}</label><br />";
		}

	}
      
    echo $html;  
      
}
