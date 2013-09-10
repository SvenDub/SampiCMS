<?php

/**
  * SampiCMS directory file
  *
  * Opens if the user navigates to the installation directory.
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
<title>SampiCMS</title>
</head>
<body>
	<h1>SampiCMS</h1>
	<p>
		This site is powered by <a href="">SampiCMS</a>, a lightweight Content Management System.
	</p>
	<p>
		Looking for the site? Go back <a href="<?php echo substr($_SERVER['SCRIPT_NAME'],0,-15); ?>">here</a>.<br /> Looking for the admin interface? You
		can find it at <a href="<?php echo substr($_SERVER['SCRIPT_NAME'],0,-9).'admin'; ?>"><?php echo substr($_SERVER['SCRIPT_NAME'],0,-9).'admin'; ?></a>
	</p>
</body>
</html>