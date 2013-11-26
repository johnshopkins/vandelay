<?php

return array(

	"url" => array(
		"type" => "text",
		"label" => "Configuration Directory (absolute)",
		"validation" => function ($input) {

			// make sure there is not a slash at the end
			if (substr($input, -1) === "/") {
				$sanitized = substr($input, 0, strlen($input) -1);
			} else {
				$sanitized = $input;
			}

			$file = $sanitized . "/test.json";
			$fopen = fopen($file, "w");
			
			if (!$fopen) {
				$message = "The directory `{$sanitized}` is not writable by WordPress. Please make this directory writable or choose a different directory.";
				add_settings_error("vandelay_config_url", "not-writable", $message);
			} else {
				fclose($fopen);
				unlink($file);
			}

			return apply_filters(__FUNCTION__, $sanitized, $input);  
		}
	)

);