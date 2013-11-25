<?php
/*
Plugin Name: Vandelay
Description: Export and import WordPress settings
Author: Jen Wachter
Version: 0.1
*/

$path = plugin_dir_path(__FILE__);


// load vandelay command
if ( defined("WP_CLI") && WP_CLI ) {
	include $path . "VandelayCommand.php";
	include $path . "workers/Worker.php";

	// load the workers
	$files = array_diff(scandir($path. "workers"), array("..", "."));
	foreach ($files as $file) {
		include_once $path . "workers/{$file}";
	}
}


// create vandelay settings page
add_action("admin_menu", function() {
	add_submenu_page("options-general.php", "Vandelay options", "Vandelay", "activate_plugins", "vandelay", "vandelay_options_display");
});

function vandelay_options_display() {  
?>  
    <!-- Create a header in the default WordPress 'wrap' container -->  
    <div class="wrap">  
      
        <div id="icon-themes" class="icon32"></div>  
        <h2>Vandelay Options</h2>  
        <?php settings_errors(); ?>  
          
        <form method="post" action="options.php">  
  
            <?php settings_fields( 'vandelay' ); ?>  
            <?php do_settings_sections( 'vandelay' ); ?>   
          
            <?php submit_button(); ?>  
              
        </form>  
          
    </div><!-- /.wrap -->  
<?php  
}


// load settings
$files = array_diff(scandir($path. "settings"), array("..", "."));
foreach ($files as $file) {
	include_once $path . "settings/{$file}";
}