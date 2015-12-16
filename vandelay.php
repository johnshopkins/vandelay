<?php
/*
Plugin Name: Vandelay
Description: Export and import Advanced Custom Field settings
Author: Jen Wachter
Version: 0.2
*/
ini_set("display_errors", true); error_reporting(E_ALL);

// load vandelay command
if (defined("WP_CLI") && WP_CLI) {
  WP_CLI::add_command("vandelay", "\\vandelay\\commands\\Vandelay");
}
