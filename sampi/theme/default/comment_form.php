<?php
/**
 * SampiCMS theme post comment
 * SampiCMS's default theme
 *
 * @author Sven Dubbeld <sven.dubbeld1@gmail.com>
 * @package SampiCMS\Theme\default
 */
/**
 * Start PHPDoc
 */
$phpdoc;
?>
<div id="comment_post">
	<div id="comment_post_header">Leave a comment:</div>
	<form id="comment_post_form" method="post" onsubmit="return postComment();">
		<input type="text" name="commenter" id="comment_post_form_author" placeholder="Name" required="required" /><br />
		<div class="textarea-wrapper">
			<textarea name="comment" id="comment_post_form_content" rows="12" cols="75" placeholder="Comment" required="required"></textarea>
		</div>
		<div id="comment_post_form_footer">
			<input type="text" name="post_nr" id="comment_post_form_post_nr" value="<?php echo $this->getNr(); ?>" />
			<input type="text" name="type" id="comment_post_form_type" value="comment" />
			<input type="submit" name="submit" id="comment_post_form_submit" value="Submit" />
			<input type="reset" name="reset" id="comment_post_form_reset" value="Cancel" />
		</div>
	</form>
</div>