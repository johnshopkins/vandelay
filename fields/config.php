<?php

return array(

	"url" => array(
		"type" => "text",
		"label" => "Configuration Directory (absolute)",
		"validation" => function ($input) {
			$file = $input . "/test.json";
			$fopen = fopen($file, "w");
			
			if (!$fopen) {
				$message = "The directory `{$input}` is not writable by WordPress. Please make this directory writable or choose a different directory.";
				add_settings_error("vandelay_config_url", "not-writable", $message);
			} else {
				fclose($fopen);
			}

			return apply_filters(__FUNCTION__, $input, $input);  
		}
	)

);