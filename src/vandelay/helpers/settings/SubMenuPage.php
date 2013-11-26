<?php

namespace vandelay\helpers\settings;

class SubMenuPage
{
	public $id;

	protected $parent;

	protected $pageTitle;

	protected $menuTitle;

	protected $capability;

	protected $menuSlug;

	protected $content;

	public function __construct($parent, $pageTitle, $menuTitle, $capability, $menuSlug, $content = "")
	{
		$this->parent = $parent;
		$this->pageTitle = $pageTitle;
		$this->menuTitle = $menuTitle;
		$this->capability = $capability;
		$this->menuSlug = $menuSlug;
		$this->content = $content;

		$this->id = $this->menuSlug;

		add_action("admin_menu", array($this, "addPage"));
	}

	public function addPage()
	{
		add_submenu_page(
			$this->parent,
			$this->pageTitle,
			$this->menuTitle,
			$this->capability,
			$this->menuSlug,
			array($this, "addContent")
		);
	}

	/**
	 * Handle the display of the admin page
	 * @return null
	 */
	public function addContent() {  
	?>
	    <div class="wrap">

	        <?php screen_icon(); ?>
	        <h2><?php echo $this->pageTitle; ?></h2>
	        <?php echo $this->content; ?>

	        <form method="post" action="options.php">

	            <?php settings_fields($this->menuSlug); ?>
	            <?php do_settings_sections($this->menuSlug); ?>
	            <?php submit_button(); ?>

	        </form>

	    </div>
	<?php  
	}
}