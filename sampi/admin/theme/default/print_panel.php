<?php

/**
 * SampiCMS admin theme panel
 *
 * SampiCMS's default admin theme
 *
 * @author Sven Dubbeld <sven.dubbeld1@gmail.com>
 */
/**
 * Namespace
 */
namespace SampiCMS\Admin\Theme\Sampi13;
use SampiCMS;
use SampiCMS\Admin;

global $panelBody;
if ($panelBody) {
	$this->showContent ();
} else {
	?>
<div id="panel_<?php echo $this->getNr(); ?>">
	<div id="panel_<?php echo $this->getNr(); ?>_header">
		<div id="panel_<?php echo $this->getNr(); ?>_header_title"><?php echo $this->getTitle(); ?></div>
	</div>
	<div id="panel_<?php echo $this->getNr(); ?>_content" data-name="<?php echo $this->getFilename(); ?>">
		<?php $this->showContent(); ?>
	</div>
	<div id="panel_<?php echo $this->getNr();?>_footer">
		<input name="settings[<?php echo $this->getNr(); ?>][submit]" onclick="return saveSettings('<?php echo $this->getFilename(); ?>');" type="button"
			class="button-main" value="Save" />
	</div>
</div>
<?php
}
?>