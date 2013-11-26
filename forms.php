<?php



function vandelay_create_field($type, $machinename, $title, $section, $fields = null)
{
	add_settings_field(   
	    "vandelay_setting_{$machinename}",			// field's unique ID
	    $title,										// Generl settings
	    "valdelay_print_{$type}",						// function that renders the option UI
	    "vandelay",									// page to add this field to
	    $section,									// section to add this fiel to
	    array(										// array of arguments to pass to the callback. 
	        $machinename, $title, $fields  
	    )  
	);

	register_setting("vandelay", "vandelay_setting_{$machinename}");  
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