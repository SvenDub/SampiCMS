<?php
/**
 * SampiCMS panel
 *
 * Most common settings that affect SampiCMS's behavior.
 * @author Sven Dubbeld <sven.dubbeld1@gmail.com>
 * @package SampiCMS\Admin
 */
/**
 * Start PHPDoc
 */
$phpdoc;
?>
<p>Most common settings that affect SampiCMS's behavior.</p>
<table>
	<tr>
		<td>Name of the site</td>
		<td><input type="text" name="settings[<?php echo $this->getNr(); ?>][site_title]" value="<?php echo site_title; ?>" /></td>
	</tr>
	<tr>
		<td>Description of the site</td>
		<td><input type="text" name="settings[<?php echo $this->getNr(); ?>][site_description]" value="<?php echo site_description; ?>" /></td>
	</tr>
	<tr>
		<td>Date-time format to use for the post date-time</td>
		<td><select name="settings[<?php echo $this->getNr(); ?>][date_format]">
  			<?php
					$values = array (
							'j-n-y',
							'j-n-y G:i',
							'Y-m-d',
							'Y-m-d H:i:s',
							'F j, Y',
							'F j, Y, g:i a'
					);
					for($i = 0; $i < count ( $values ); $i ++) {
						if ($values [$i] == date_format) {
							echo '<option value="' . $values [$i] . '" selected>' . date ( $values [$i] ) . ' - ' . $values [$i] . '</option>';
						} else {
							echo '<option value="' . $values [$i] . '">' . date ( $values [$i] ) . ' - ' . $values [$i] . '</option>';
						}
					}
					?>
			<option>Custom...</option>
		</select></td>
	</tr>
	<tr>
		<td>Values to show for the amount of posts per page</td>
		<td><input type="text" name="settings[<?php echo $this->getNr();?>][per_page_values]" value="<?php echo per_page_values; ?>" /></td>
	</tr>
</table>
