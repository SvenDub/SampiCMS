<?php
/**
 * SampiCMS admin theme panel
 * SampiCMS's default admin theme
 *
 * @author Sven Dubbeld <sven.dubbeld1@gmail.com>
 * @package SampiCMS\Admin\Theme\default
 */
/**
 * Start PHPDoc
 */
$phpdoc;
?>
<div id="panel_<?php echo $this->getNr(); ?>">
	<div id="panel_<?php echo $this->getNr(); ?>_header">
		<div id="panel_<?php echo $this->getNr(); ?>_header_title"><?php echo $this->getTitle(); ?></div>
	</div>
	<div id="panel_<?php echo $this->getNr(); ?>_content">
		<?php $this->getContent(); ?>
	</div>
	<div id="panel_<?php echo $this->getNr();?>_footer">
		<input name="settings[<?php echo $this->getNr(); ?>][submit]" type="submit" value="Save" />
	</div>
</div>