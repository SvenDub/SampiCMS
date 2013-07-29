<?php
/**
 * SampiCMS admin header file
 * Opens <html> and <body>-tags, adds <head>-part.
 * @author Sven Dubbeld <sven.dubbeld1@gmail.com>
 * @package SampiCMS\Admin
 */
/**
 * Start PHPDoc
 */
$phpdoc;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>
        	<?php
									echo sampi_info ( 'admin_window_title' );
									?>
        </title>
       	<link href="<?php echo ADMIN_REL_ROOT.'/theme/'.theme.'/style.css'; ?>" type='text/css' rel='stylesheet' />
<link href="<?php echo ADMIN_REL_ROOT.'/theme/'.theme.'/style.php'; ?>" type='text/css' rel='stylesheet' />
<link href="<?php echo ADMIN_REL_ROOT.'/favicon.ico'; ?>" rel='shortcut icon' type='image/x-icon' />
<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
<meta name="generator" content="SampiCMS <?php echo sampi_info('version'); ?>" />
		<?php
		if (file_exists ( ADMIN_ROOT . '/theme/' . theme . '/functions.js' )) {
			echo '<script src="' . ADMIN_REL_ROOT . '/theme/' . theme . '/functions.js" type="text/javascript"></script>';
		}
		?>
    </head>
<body>