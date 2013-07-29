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

global $panelBody;
if ($panelBody) {
	$this->getContent();
} else {
?>
<div id="panel_<?php echo $this->getNr(); ?>">
	<div id="panel_<?php echo $this->getNr(); ?>_header">
		<div id="panel_<?php echo $this->getNr(); ?>_header_title"><?php echo $this->getTitle(); ?></div>
	</div>
	<div id="panel_<?php echo $this->getNr(); ?>_content" data-name="<?php echo $this->getFilename(); ?>">
		<?php $this->getContent(); ?>
	</div>
	<div id="panel_<?php echo $this->getNr();?>_footer">
		<input name="settings[<?php echo $this->getNr(); ?>][submit]" onclick="return saveSettings('<?php echo $this->getFilename(); ?>');" type="button" class="button-main" value="Save" />
	</div>
</div>
<?php
}
?>