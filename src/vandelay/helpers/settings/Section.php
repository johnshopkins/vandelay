<?php

namespace vandelay\helpers\settings;

class Section
{
	public $id;
	protected $page;
	protected $machinename;
	protected $title;
	protected $content;

	public function __construct($page, $machinename, $title, $content = "")
	{
		$this->page = $page;
		$this->machinename = $machinename;
		$this->title = $title;
		$this->content = $content;

		$this->id = "{$this->page->id}_{$this->machinename}";
		
		add_action("admin_init", array($this, "addSection"));
	}

	public function addSection()
	{
		add_settings_section(
			$this->id,
			$this->title,
			array($this, "addContent"),
			$this->page->id
		);
	}

	public function addContent()
	{
		echo $this->content;
	}
}