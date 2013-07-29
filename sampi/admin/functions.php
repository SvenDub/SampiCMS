<?php
/**
 * SampiCMS admin functions file.
 * This file contains almost all functions that are required to run the administration module of SampiCMS properly.
 * @author Sven Dubbeld <sven.dubbeld1@gmail.com>
 * @package SampiCMS\Admin
 */
/**
 * Start PHPDoc
 */
$phpdoc;

/**
 * First function called upon start.
 * Initializes connection with database.
 */
function sampi_admin_init() {
	global $db;

	$db = new SampiAdminDbFunctions();
	
	sampi_admin_auth ();
	sampi_get_params ();
	$db->getSettings();
	sampi_admin_header ();
	sampi_admin_theme ();
	sampi_admin_footer ();
}

/**
 * Provides authentication for the administration interface.
 * Uses a connection with the MySQL database to verify the users identity. If the user is not logged in, a loginscreen will show up.
 */
function sampi_admin_auth() {
	global $current_user, $db;
	if (isset ( $_GET ['logout'] )) {
		setcookie ( 'username', null, time () - 3600 );
		setcookie ( 'password', null, time () - 3600 );
		header ( 'Location: ' . ADMIN_REL_ROOT );
	} elseif (! isset ( $_COOKIE ['username'] )) {
		if (isset ( $_POST ['login'] ['username'] ) && isset ( $_POST ['login'] ['password'] )) {
			$username = $_POST ['login'] ['username'];
			$password = $_POST ['login'] ['password'];
			if ($db->checkAuth($username, $password) !== false) {
				setcookie ( 'username', $username, time() + 60 * 60 * 24 * 30 );
				setcookie ( 'password', $password, time() + 60 * 60 * 24 * 30 );
			} else {
				$error = true;
				include (ADMIN_ROOT . '/login.php');
				die ();
			}
		} else {
			include (ADMIN_ROOT . '/login.php');
			die ();
		}
	} else {
		$username = $_COOKIE ['username'];
		$password = $_COOKIE ['password'];
		if ($db->checkAuth($username, $password) !== false) {
			$current_user = $username;
		} else {
			$error = true;
			setcookie ( 'username', null, time () - 3600 );
			setcookie ( 'password', null, time () - 3600 );
			include (ADMIN_ROOT . '/login.php');
			die ();
		}
	}
}

/**
 * Includes header.
 * Opens &lt;html&gt;-tag, adds &lt;head&gt;-part and opens &lt;body&gt;-tag.
 */
function sampi_admin_header() {
	include_once ADMIN_ROOT . '/header.php';
}

/**
 * Includes footer.
 * Closes &lt;body&gt; and &lt;html&gt;-tags.
 */
function sampi_admin_footer() {
	include_once ADMIN_ROOT . '/footer.php';
}

/**
 * Includes theme main file.
 */
function sampi_admin_theme() {
	include_once ADMIN_ROOT . '/theme/' . admin_theme . '/index.php';
}

/**
 * Includes theme footer, bottom of the page
 */
function sampi_admin_theme_header() {
	include_once ADMIN_ROOT . '/theme/' . admin_theme . '/header.php';
}

/**
 * Includes global- and theme-sidebar.
 */
function sampi_admin_sidebar() {
	echo '<div id="sidebar">';
	include_once ADMIN_ROOT . '/sidebar.php';
	include_once ADMIN_ROOT . '/theme/' . admin_theme . '/sidebar.php';
	echo '</div>';
}

/**
 * Determines wether to show a single panel or all panels.
 */
function sampi_admin_mode_selector() {
	global $p, $db;
	if ($p !== false) {
		$panel = $db->getSinglePanel($p);
		$panel->show();
	} else {
		$panels = $db->getPanels();
		foreach ($panels as $key=>$val) {
			$val->show();
		}
	}
}

function sampi_admin_panel_links() {
	global $con;
	$query = "SELECT panel_nr, name FROM sampi_panels";
	$result = mysqli_query ( $con, $query );
	while ( list ( $nr, $name ) = mysqli_fetch_row ( $result ) ) {
		echo '<li><a class="sidebar_link" href="?p=' . $nr . '">' . $name . '</a></li>';
	}
}

class SampiAdminDbFunctions extends SampiDbFunctions {
	public function getPanels() {
		$stmt = $this->con->prepare ( "SELECT panel_nr, name, filename FROM sampi_panels" );
		$stmt->execute ();
		$stmt->bind_result ( $panel_nr, $name, $filename );
		$panels = array ();
		while ( $stmt->fetch () ) {
			$panels [$panel_nr] = new SampiAdminPanel($panel_nr, $name, $filename);
		}
		return $panels;
	}
	public function getSinglePanel($p) {
		$stmt = $this->con->prepare( "SELECT panel_nr, name, filename FROM sampi_panels WHERE panel_nr=?" );
		$stmt->bind_param('i', $p);
		$stmt->execute();
		$stmt->bind_result( $panel_nr, $name, $filename );
		$stmt->fetch();
		return new SampiAdminPanel($panel_nr, $name, $filename);
	}
	public function getSinglePanelByName($p) {
		$stmt = $this->con->prepare( "SELECT panel_nr, name, filename FROM sampi_panels WHERE filename=?" );
		$stmt->bind_param('s', $p);
		$stmt->execute();
		$stmt->bind_result( $panel_nr, $name, $filename );
		$stmt->fetch();
		return new SampiAdminPanel($panel_nr, $name, $filename);
	}
	public function saveSetting($setting, $value) {
		$stmt = $this->con->prepare( "UPDATE sampi_settings SET setting_value=? WHERE setting_name=?" );
		$stmt->bind_param('ss', $value, $setting);
		$stmt->execute();
		$stmt->free_result();
		$stmt->close();
	}
	
}

class SampiAdminPanel {
	private $panel_nr;
	private $name;
	private $filename;
	function __construct($panel_nr, $name, $filename) {
		$this->panel_nr = $panel_nr;
		$this->name = $name;
		$this->filename = $filename;
	}
	public function show() {
		include ADMIN_ROOT.'/theme/'.admin_theme.'/print_panel.php';
	}
	public function showBody() {
		global $panelBody;
		$panelBody = true;
		include ADMIN_ROOT.'/theme/'.admin_theme.'/print_panel.php';
	}
	public function getNr() {
		return $this->panel_nr;
	}
	public function getContent() {
		include ADMIN_ROOT.'/panels/'.$this->filename.'.php';
	}
	public function getTitle() {
		return $this->name;
	}
	public function getFilename() {
		return $this->filename;
	}
}
?>