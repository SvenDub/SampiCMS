<?php
/**
  * SampiCMS directory file
  * Opens if the user navigates to the installation directory.
  * @author Sven Dubbeld <sven.dubbeld1@gmail.com>
  * @package SampiCMS
  */
/**
 * Start PHPDoc
 */
$phpdoc;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>SampiCMS</title>
</head>
<body>
	<h1>SampiCMS</h1>
	<p>
		This site is powered by <a href="">SampiCMS</a>, a lightweight Content Management System.
	</p>
	<p>
		Looking for the site? Go back <a href="<?php echo substr($_SERVER['PHP_SELF'],0,-15); ?>">here</a>.<br />
		Looking for the admin interface? You can find it at <a href="<?php echo substr($_SERVER['PHP_SELF'],0,-9).'admin'; ?>"><?php echo substr($_SERVER['PHP_SELF'],0,-9).'admin'; ?></a>
	</p>
</body>
</html>