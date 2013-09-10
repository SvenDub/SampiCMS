<?php

/**
 * SampiCMS admin functions file.
 *
 * This file contains almost all functions that are required to run the administration module of SampiCMS properly.
 *
 * @author Sven Dubbeld <sven.dubbeld1@gmail.com>
 */
/**
 * Namespace
 */
namespace SampiCMS\Admin;

use SampiCMS;

/**
 * First function called upon start.
 *
 * Initializes connection with database.
 */
function init() {
	global $db;
	
	$db = new DbFunctions ();
	
	SampiCMS\admin_auth ();
	SampiCMS\get_params ();
	$db->getSettings ();
	header ();
	theme ();
	footer ();
}

/**
 * Include header.
 *
 * Open &lt;html&gt;-tag, add &lt;head&gt;-part and open &lt;body&gt;-tag.
 */
function header() {
	include_once SampiCMS\ADMIN_ROOT . '/header.php';
}

/**
 * Include footer.
 *
 * Close &lt;body&gt; and &lt;html&gt;-tags.
 */
function footer() {
	include_once SampiCMS\ADMIN_ROOT . '/footer.php';
}

/**
 * Include theme main file.
 */
function theme() {
	include_once SampiCMS\ADMIN_ROOT . '/theme/' . admin_theme . '/index.php';
}

/**
 * Include theme footer, bottom of the page
 */
function theme_header() {
	include_once SampiCMS\ADMIN_ROOT . '/theme/' . admin_theme . '/header.php';
}

/**
 * Include global- and theme-sidebar.
 */
function sidebar() {
	echo '<div id="sidebar">';
	include_once SampiCMS\ADMIN_ROOT . '/sidebar.php';
	include_once SampiCMS\ADMIN_ROOT . '/theme/' . admin_theme . '/sidebar.php';
	echo '</div>';
}

/**
 * Determine whether to show a single panel or all panels.
 */
function mode_selector() {
	global $p, $db;
	if ($p !== false) {
		$panel = $db->getSinglePanel ( $p );
		$panel->show ();
	} else {
		$panels = $db->getPanels ();
		foreach ( $panels as $key => $val ) {
			$val->show ();
		}
	}
}

/**
 * Show the links to the panels.
 */
function panel_links() {
	global $db;
	$stmt = $db->con->prepare ( "SELECT panel_nr, name FROM sampi_panels" );
	$stmt->execute ();
	$stmt->bind_result ( $nr, $name );
	while ( $stmt->fetch () ) {
		echo '<li><a class="sidebar_link" href="?p=' . $nr . '">' . $name . '</a></li>';
	}
	$stmt->free_result ();
	$stmt->close ();
}

/**
 * Extension for the administration module to the Database Functions.
 *
 * @name SampiCMS Admin Database Functions
 * @author Sven Dubbeld <sven.dubbeld1@gmail.com>
 * @package SampiCMS\Admin
 */
class DbFunctions extends SampiCMS\DbFunctions {
	/**
	 * Get all panels from the database.
	 *
	 * Return them as an array with \SampiCMS\Admin\AdminPanel 's.
	 *
	 * @return array
	 * @see \SampiCMS\Admin\AdminPanel
	 */
	public function getPanels() {
		$stmt = $this->con->prepare ( "SELECT panel_nr, name, filename FROM sampi_panels" );
		$stmt->execute ();
		$stmt->bind_result ( $panel_nr, $name, $filename );
		$panels = array ();
		while ( $stmt->fetch () ) {
			$panels [$panel_nr] = new AdminPanel ( $panel_nr, $name, $filename );
		}
		return $panels;
	}
	/**
	 * Get a single panel from the database.
	 *
	 * @param int $p
	 *        	The id of the panel.
	 * @return \SampiCMS\Admin\AdminPanel
	 * @see \SampiCMS\Admin\AdminPanel
	 */
	public function getSinglePanel($p) {
		$stmt = $this->con->prepare ( "SELECT panel_nr, name, filename FROM sampi_panels WHERE panel_nr=?" );
		$stmt->bind_param ( 'i', $p );
		$stmt->execute ();
		$stmt->bind_result ( $panel_nr, $name, $filename );
		$stmt->fetch ();
		return new AdminPanel ( $panel_nr, $name, $filename );
	}
	/**
	 * Get a single panel from the database by it's filename.
	 *
	 * @param string $p
	 *        	The filename of the panel.
	 * @return \SampiCMS\Admin\AdminPanel
	 * @see \SampiCMS\Admin\AdminPanel
	 */
	public function getSinglePanelByName($p) {
		$stmt = $this->con->prepare ( "SELECT panel_nr, name, filename FROM sampi_panels WHERE filename=?" );
		$stmt->bind_param ( 's', $p );
		$stmt->execute ();
		$stmt->bind_result ( $panel_nr, $name, $filename );
		$stmt->fetch ();
		return new AdminPanel ( $panel_nr, $name, $filename );
	}
	/**
	 * Save a setting to the database.
	 *
	 * @param string $setting
	 *        	The name of the setting.
	 * @param string $value
	 *        	The value of the setting.
	 */
	public function saveSetting($setting, $value) {
		$stmt = $this->con->prepare ( "UPDATE sampi_settings SET setting_value=? WHERE setting_name=?" );
		$stmt->bind_param ( 'ss', $value, $setting );
		$stmt->execute ();
		$stmt->free_result ();
		$stmt->close ();
	}
}

/**
 * Provides all functionality for administration panels.
 *
 * @name SampiCMS Administration panel
 * @author Sven Dubbeld <sven.dubbeld1@gmail.com>
 * @package \SampiCMS\Admin
 */
class AdminPanel {
	/**
	 * The id of the panel.
	 *
	 * @var int
	 */
	private $panel_nr;
	/**
	 * The name of the panel.
	 *
	 * @var string
	 */
	private $name;
	/**
	 * The filename of the panel.
	 *
	 * @var string
	 */
	private $filename;
	/**
	 * Create a new instance of an administration panel to interact with.
	 *
	 * @param int $panel_nr
	 *        	The id of the panel.
	 * @param string $name
	 *        	The name of the panel.
	 * @param string $filename
	 *        	The filename of the panel.
	 */
	function __construct($panel_nr, $name, $filename) {
		$this->panel_nr = $panel_nr;
		$this->name = $name;
		$this->filename = $filename;
	}
	/**
	 * Show the panel.
	 */
	public function show() {
		include SampiCMS\ADMIN_ROOT . '/theme/' . admin_theme . '/print_panel.php';
	}
	/**
	 * Show just the body of the panel.
	 *
	 * This excludes title and submit button, as well as the panel itself.
	 */
	public function showBody() {
		global $panelBody;
		$panelBody = true;
		include SampiCMS\ADMIN_ROOT . '/theme/' . admin_theme . '/print_panel.php';
	}
	/**
	 * Get the id of the panel.
	 *
	 * @return int
	 */
	public function getNr() {
		return $this->panel_nr;
	}
	/**
	 * Show the content of the panel.
	 */
	public function showContent() {
		include SampiCMS\ADMIN_ROOT . '/panels/' . $this->filename . '.php';
	}
	/**
	 * Get the name of the panel.
	 *
	 * @return string
	 */
	public function getTitle() {
		return $this->name;
	}
	/**
	 * Get the filename of the panel.
	 *
	 * @return string
	 */
	public function getFilename() {
		return $this->filename;
	}
}
?>