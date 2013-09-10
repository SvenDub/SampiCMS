<?php
/**
 * SampiCMS admin header file
 *
 * Opens <html> and <body>-tags, adds <head>-part.
 *
 * @author Sven Dubbeld <sven.dubbeld1@gmail.com>
 */
/**
 * Namespace
 */
namespace SampiCMS\Admin;
use SampiCMS;
?>
<!DOCTYPE html>
<html>
<head>
<title><?php echo SampiCMS\info ( 'admin_window_title' ); ?></title>
<link href="<?php echo SampiCMS\ADMIN_REL_ROOT.'/theme/'.theme.'/style.css'; ?>" type='text/css' rel='stylesheet' />
<link href="<?php echo SampiCMS\ADMIN_REL_ROOT.'/theme/'.theme.'/style.php'; ?>" type='text/css' rel='stylesheet' />
<link href="<?php echo SampiCMS\ADMIN_REL_ROOT . '/theme/' . admin_theme . '/global_style.css'; ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo SampiCMS\ADMIN_REL_ROOT.'/favicon.ico'; ?>" rel='shortcut icon' type='image/x-icon' />
<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
<meta name="generator" content="SampiCMS <?php echo SampiCMS\info('version'); ?>" />
<?php
if (file_exists ( SampiCMS\ADMIN_ROOT . '/theme/' . theme . '/functions.js' )) {
	echo '<script src="' . SampiCMS\ADMIN_REL_ROOT . '/theme/' . theme . '/functions.js" type="text/javascript"></script>';
}
echo '<script src="' . SampiCMS\ADMIN_REL_ROOT . '/functions.js" type="text/javascript"></script>';
?>
<meta name="REL_ROOT" content="<?php echo SampiCMS\REL_ROOT; ?>">
<meta name="ADMIN_REL_ROOT" content="<?php echo SampiCMS\ADMIN_REL_ROOT; ?>">
</head>
<body>