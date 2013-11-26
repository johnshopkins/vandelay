<?php

namespace vandelay\helpers\settings;
 
class Field
{
	/**
	 * Type of field this is
	 * @var string
	 */
	protected $type;

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
	 * Default value of this field
	 * @var string
	 */
	protected $default;

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
	 * ID of this field group
	 * @var sting
	 */
	public $id;

	public function __construct($type, $machinename, $title, $default, $page, $section)
	{
		$this->type = $type;
		$this->machinename = $machinename;
		$this->title = $title;
		$this->default = $default;
		$this->page = $page->id;
		$this->section = $section->id;

		$this->id = "{$this->section}_{$this->machinename}";

		add_action("admin_init", array($this, "addField"));
	}


	public function addField()
	{
		add_settings_field(
			$this->id,
		    $this->title,
		    array($this, "printField"),
		    $this->page,
		    $this->section,
		    array($this->type, $this->default)  
		);

		register_setting($this->page, $this->id);
	}

	public function printField($args)
	{
		$type = $args[0];
		$default = $args[1];

		$method = "get_{$type}";
		echo $this->$method($this->id, $default);
	}

	protected function get_checkbox($optionKey, $default = null)
	{
		$currentValue = get_option($optionKey);

		$checked = checked(1, $currentValue, false);

		return "<input type=\"checkbox\" id=\"\" name=\"{$name}\" value=\"1\" " . $checked . " />";
	}

	protected function get_text($optionKey, $default = null)
	{
		$currentValue = get_option($optionKey);

		$html = "";

		$html .= "<input type=\"text\" id=\"\" name=\"{$optionKey}\" value=\"" . $currentValue . "\" class=\"regular-text\">";

		return $html;
	}

}