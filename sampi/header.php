<?php

/**
 * SampiCMS header file
 *
 * Opens <html> and <body>-tags, adds <head>-part.
 *
 * @author Sven Dubbeld <sven.dubbeld1@gmail.com>
 */
/**
 * Namespace
 */
namespace SampiCMS;
use SampiCMS;
?>
<!DOCTYPE html>
<html>
<head>
<title><?php echo info ( 'window_title' ); ?></title>
<link href="<?php echo SampiCMS\REL_ROOT.'/sampi/theme/'.theme.'/style.css'; ?>" type='text/css' rel='stylesheet' />
<link href="<?php echo SampiCMS\REL_ROOT.'/sampi/theme/'.theme.'/style.php'; ?>" type='text/css' rel='stylesheet' />
<link href="<?php echo SampiCMS\REL_ROOT . '/sampi/theme/' . theme . '/global_style.css'; ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo SampiCMS\REL_ROOT.'/sampi/favicon.ico'; ?>" rel='shortcut icon' type='image/x-icon' />
<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
<meta name="generator" content="SampiCMS <?php echo info('version'); ?>" />
<?php integration_meta(); ?>
<script src="<?php echo SampiCMS\REL_ROOT . '/sampi/functions.js'; ?>" type="text/javascript"></script>
<?php
if (file_exists ( SampiCMS\ROOT . '/sampi/theme/' . theme . '/functions.js' )) {
	echo '<script src="' . SampiCMS\REL_ROOT . '/sampi/theme/' . theme . '/functions.js" type="text/javascript"></script>';
}
?>
<meta name="REL_ROOT" content="<?php echo SampiCMS\REL_ROOT; ?>">
<meta name="ADMIN_REL_ROOT" content="<?php echo SampiCMS\ADMIN_REL_ROOT; ?>">
</head>
<body>