<?php
/*
Plugin Name: Vandelay
Description: Export and import WordPress settings
Author: Jen Wachter
Version: 0.1
*/

$path = plugin_dir_path(__FILE__);

if ( defined("WP_CLI") && WP_CLI ) {
	include $path . "VandelayCommand.php";
	include $path . "workers/Worker.php";

	// load the workers
	$files = array_diff(scandir($path. "workers"), array("..", "."));
	foreach ($files as $file) {
		include_once $path . "workers/{$file}";
	}
}