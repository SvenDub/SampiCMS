<?php
/**
 * SampiCMS theme sidebar
 *
 * Show the sidebar.
 *
 * @author Sven Dubbeld <sven.dubbeld1@gmail.com>
 * @package SampiCMS\Theme\Sampi13
 */
/**
 * Namespace
 */
namespace SampiCMS\Theme\Sampi13;
use SampiCMS;

global $db;

$statics = $db->getAllStatics();
?>
<ul class="ui-sidebar-list">
<?php
foreach ($statics as $page_nr => $static) {
	echo '<li><a class="ui-sidebar-link" href="?s='.$static->getNr().'">'.$static->getTitle().'</a></li>';
}

?>
</ul>