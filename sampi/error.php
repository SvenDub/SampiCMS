<?php

/**
 * SampiCMS error file.
 *
 * Displays the error page if a fatal error has occurred.
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
<title>Error!</title>
</head>
<body style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #EAEAEA;">
	<img src="<?php echo SampiCMS\REL_ROOT; ?>/sampi/resources/images/logo_m.png" alt="SampiCMS Logo" style="float: right;" />
	<h1>Error encountered!</h1>
	<p>
		SampiCMS encountered a fatal error. Click <a href="<?php echo $_SERVER['HTTP_REFERER']; ?>">here</a> to try again, or return to the <a
			href="<?php echo SampiCMS\REL_ROOT;?>">homepage</a>. If this error keeps occurring, please <a href="mailto:<?php echo SampiCMS\admin_mail; ?>">contact
			the webmaster</a> of this site.
	</p>
	<p style="font-family: 'Courier New', Courier, monospace;">Error code: <?php echo $_GET['error']; ?><br />
		Time: <?php echo date('Y-m-d H:i:s'); ?><br />
		Server: <?php echo $_SERVER['SERVER_NAME']; ?></p>
</body>
</html>