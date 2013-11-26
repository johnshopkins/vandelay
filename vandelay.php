<?php
/*
Plugin Name: Vandelay
Description: Export and import WordPress settings
Author: Jen Wachter
Version: 0.1
*/


// load vandelay command
if (defined("WP_CLI") && WP_CLI) {
    WP_CLI::add_command("vandelay", "\\vandelay\\commands\\Vandelay");
}



// vandelay page
$menuPage = new vandelay\helpers\settings\SubMenuPage(
	"options-general.php",
	"Vandelay Options",
	"Vandelay",
	"activate_plugins",
	"vandelay"
);


// configuration section
$config = include __DIR__ . "/fields/config.php";
$configSection = new vandelay\helpers\settings\Section(
	$menuPage,
	"config",
	"Configuration"
);
vandelay_create_fields($config, $menuPage, $configSection);


// wp options section
$wpoptions = include __DIR__ . "/fields/wpoptions.php";
$wpoptionsSection = new vandelay\helpers\settings\Section(
	$menuPage,
	"wp_options",
	"WordPress Options"
);
vandelay_create_fields($wpoptions, $menuPage, $wpoptionsSection);




function vandelay_create_fields($fields, $page, $section)
{
	foreach ($fields as $machinename => $details) {

		$validation = isset($details["validation"]) ? $details["validation"] : null;

		// this field has subfields
		if (isset($details["fields"])) {
			new vandelay\helpers\settings\FieldGroup(
				$machinename,
				$details["label"],
				$details["fields"],
				$page,
				$section,
				$validation
			);
		} else {
			$default = isset($details["default"]) ? $details["default"] : null;
			new vandelay\helpers\settings\Field(
				$details["type"],
				$machinename,
				$details["label"],
				$default,
				$page,
				$section,
				$validation
			);
		}
}
}