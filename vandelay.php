<?php
/*
Plugin Name: Vandelay
Description: Export and import WordPress settings
Author: Jen Wachter
Version: 0.1
*/


if ( defined("WP_CLI") && WP_CLI ) {
	include __DIR__ . "/Worker.php";
	include __DIR__ . "/VandelayCommand.php";

	// load the workers
	$files = array_diff(scandir(__DIR__ . "/workers"), array("..", "."));
	foreach ($files as $file) {
		include_once "workers/{$file}";
	}
}