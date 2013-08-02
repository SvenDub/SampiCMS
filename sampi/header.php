<?php
/**
 * SampiCMS header file
 * Opens <html> and <body>-tags, adds <head>-part.
 * @author Sven Dubbeld <sven.dubbeld1@gmail.com>
 * @package SampiCMS
 */
/**
 * Start PHPDoc
 */
$phpdoc;
?>
<!DOCTYPE html>
<html>
<head>
<title><?php echo sampi_info ( 'window_title' ); ?></title>
<link href="<?php echo REL_ROOT.'/sampi/theme/'.theme.'/style.css'; ?>" type='text/css' rel='stylesheet' />
<link href="<?php echo REL_ROOT.'/sampi/theme/'.theme.'/style.php'; ?>" type='text/css' rel='stylesheet' />
<link href="<?php echo REL_ROOT . '/theme/' . theme . '/global_style.css'; ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo REL_ROOT.'/sampi/favicon.ico'; ?>" rel='shortcut icon' type='image/x-icon' />
<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
<meta name="generator" content="SampiCMS <?php echo sampi_info('version'); ?>" />
		<?php sampi_integration_meta(); ?>
		<script src="<?php echo REL_ROOT . '/sampi/functions.js'; ?>" type="text/javascript"></script>
		<?php
		if (file_exists ( ROOT . '/sampi/theme/' . theme . '/functions.js' )) {
			echo '<script src="' . REL_ROOT . '/sampi/theme/' . theme . '/functions.js" type="text/javascript"></script>';
		}
		?>
    </head>
<body>