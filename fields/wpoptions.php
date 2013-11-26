<?php

return array(

	"general" => array(
		"label" => "General",
		"fields" => array(
			"datetime" => array(
				"type" => "checkbox",
				"label" => "Date/Time"
			),
			"environment" => array(
				"type" => "checkbox",
				"label" => "Environment"
			),
			"site_settings" => array(
				"type" => "checkbox",
				"label" => "Site Settings"
			),
			"users" => array(
				"type" => "checkbox",
				"label" => "Users"
			),
			"cron" =>array(
				"type" => "checkbox",
				"label" => "Cron"
			)
		)
	),

	"widgets" => array(
		"label" => "Widgets",
		"fields" => array(
			"general" => array(
				"type" => "checkbox",
				"label" => "General"
			),
			"wordpress" => array(
				"type" => "checkbox",
				"label" => "WordPress"
			),
			"dashboard" => array(
				"type" => "checkbox",
				"label" => "Dashboard"
			)
		)
	),

	"discussion" => array(
		"label" => "Discussion",
		"fields" => array(
			"comments" => array(
				"type" => "checkbox",
				"label" => "Comments"
			),
			"avatars" => array(
				"type" => "checkbox",
				"label" => "Avatars"
			)
		)
	),

	"writing" => array(
		"label" => "Writing",
		"fields" => array(
			"general" => array(
				"type" => "checkbox",
				"label" => "General"
			),
			"viaemail" => array(
				"type" => "checkbox",
				"label" => "Post via Email"
			)
		)
	),

	"other" => array(
		"label" => "Other",
		"fields" => array(
			"permalinks" => array(
				"type" => "checkbox",
				"label" => "Permalinks"
			),
			"plugins" => array(
				"type" => "checkbox",
				"label" => "Plugins"
			),
			"themes" => array(
				"type" => "checkbox",
				"label" => "Themes"
			),
			"blogroll" => array(
				"type" => "checkbox",
				"label" => "Blogroll"
			),
			"media" => array(
				"type" => "checkbox",
				"label" => "Media"
			),
			"reading" => array(
				"type" => "checkbox",
				"label" => "Reading"
			)
		)
	)

	// plugin specific
	// "acf_version",
	// "p2p_storage"

);