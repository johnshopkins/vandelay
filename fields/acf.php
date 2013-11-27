<?php

if (!class_exists("Acf")) {
	return false;
}

$groups = get_posts(array(
	"posts_per_page" => -1,
	"post_type" => "acf",
	"post_status" => "publish"
));

$fields = array();

foreach($groups as $group) {
	$fields[$group->post_name] = array(
		"type" => "checkbox",
		"label" => $group->post_title
	);
}

return array(

	"field_groups" => array(
		"label" => "Field Groups",
		"fields" => $fields
	)
);