<?php

namespace vandelay\helpers\settings;

/**
 * Creates a section of fields. For an example of what this means,
 * go to Settings > Discussion > Default article settings. There
 * are three fields belonging to the default article settings group.
 */
class FieldGroup
{
	/**
	 * Machine-friendly name of this field group.
	 * Gets assigned to the option key
	 * @var string
	 */
	protected $machinename;

	/**
	 * Readable name of this field group.
	 * Gets assigned as the field group label.
	 * @var string
	 */
	protected $title;

	/**
	 * Definitions of fields are belong
	 * to this field group.
	 * @var array
	 */
	protected $fields = array();

	/**
	 * ID of the options page to assign
	 * this field group to.
	 * @var string
	 */
	protected $page;

	/**
	 * ID of the options section to assign
	 * this field group to.
	 * @var string
	 */
	protected $section;

	/**
	 * Validation function
	 * @var function
	 */
	protected $validation;

	/**
	 * ID of this field group
	 * @var sting
	 */
	protected $id;

	public function __construct($machinename, $title, $fields, $page, $section, $validation = null)
	{
		$this->machinename = $machinename;
		$this->title = $title;
		$this->fields = $fields;
		$this->page = $page->id;
		$this->section = $section->id;
		$this->validation = $validation;

		$this->id = "{$this->section}_{$this->machinename}";

		add_action("admin_init", array($this, "addFieldGroup"));
	}

	public function addFieldGroup()
	{
		add_settings_field(
			$this->id,
		    $this->title,
		    array($this, "printFields"),
		    $this->page,
		    $this->section,
		    array($this->title, $this->fields)  
		);

		register_setting($this->page, $this->id, $this->validation);
	}

	public function printFields($args)
	{
		$label = $args[0];
		$subfields = $args[1];

		$html = "";

		foreach ($subfields as $name => $details) {
			$method = "get_{$details['type']}";
			$default = isset($details["default"]) ? $details["default"] : null;

			$html .= $this->$method($this->id, $name, $details["label"], $default);
		}

		echo $html;
	}

	/**
	 * Create HTML for a checkbox.
	 * @param  string $optionKey Name of key of WordPress option where this value is saved (as part of an array).
	 * @param  string $key       Name of key to find this form element's specific value
	 * @param  string $label     Element's label
	 * @param  string $default   Element's default value
	 * @return string Checkbox HTML
	 */
	protected function get_checkbox($optionKey, $key, $label, $default = null)
	{
		// Find the current value of this checkbox.
		$value = $this->getOptionValue($optionKey, $key);

		// Create the name attribute of this checkbox
		$name = $this->getFieldName($optionKey, $key);

		return "<input type=\"checkbox\" id=\"\" name=\"{$name}\" value=\"1\" " . checked(1, $value, false) . " /> <label for=\"{$name}\">{$label}</label><br />";
	}

	/**
	 * Create HTML for a textbox.
	 * @param  string $optionKey Name of key of WordPress option where this value is saved (as part of an array).
	 * @param  string $key       Name of key to find this form element's specific value
	 * @param  string $label     Element's label
	 * @param  string $default   Element's default value
	 * @return string Textbox HTML
	 */
	protected function get_text($optionKey, $key, $label, $default = null)
	{
		// Find the current value of this checkbox.
		$value = $this->getOptionValue($optionKey, $key) || $default;

		// Create the name attribute of this textbox
		$name = $this->getFieldName($optionKey, $key);

		// create html
		return "<label for=\"{$name}\">{$label}</label> <input type=\"text\" id=\"\" name=\"{$name}\" value=\"" . $value . "\" class=\"regular-text\"> <br />";
	}

	/**
	 * Find an individual value in a WordPress option that is stored as an array
	 * @param  string $option WordPress option key
	 * @param  string $key    Array key to look for in option value
	 * @return string/null
	 */
	protected function getOptionValue($option, $key)
	{
		$option = get_option($option);
		return isset($option[$key]) ? $option[$key] : null;
	}

	/**
	 * Get the name attribute for a form field.
	 * @param  string $option Name of key of WordPress option where this value is saved (as part of an array).
	 * @param  string $key    Name of key to find this form element's specific value
	 * @return string
	 */
	protected function getFieldName($option, $key)
	{
		return $option . "[$key]";
	}
}