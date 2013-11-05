/**
 * SampiCMS admin functions file.
 * 
 * This file contains almost all functions that are required to run the
 * administration module of SampiCMS properly.
 * 
 * @author Sven Dubbeld <sven.dubbeld1@gmail.com>
 */
var REL_ROOT;
var ADMIN_REL_ROOT;
/**
 * JavaScript functions to execute on page load.
 * 
 * Get the relative (web) roots of SampiCMS and the admin interface.
 */
window.onload = function() {
    REL_ROOT = document.getElementsByName("REL_ROOT")[0].content;
    ADMIN_REL_ROOT = document.getElementsByName("ADMIN_REL_ROOT")[0].content;
};
/**
 * Save the panel.
 * 
 * @param panel
 * @returns {Boolean}
 */
function saveSettings(panel) {
    var a = document.querySelectorAll('[data-name]');
    var i = 0;
    while (i < a.length) {
	if (a.hasOwnProperty(i)) {
	    if (a[i].getAttribute('data-name') == panel) {
		panelDiv = a[i];
	    }
	}
	i++;
    }

    // Create HttpRequest
    var xmlhttp;
    xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() { // Handle HttpRequest
	if (xmlhttp.readyState == 4) {
	    if (xmlhttp.status == 200) {
		panelDiv.innerHTML = xmlhttp.responseText;
		showPopup("Saving...");
	    } else {
		showPopup("An error occured while saving. Please try again.");
	    }
	}
    };
    switch (panel) {
    case "general":
	var site_title = document
		.getElementById("settings[general][site_title]").value;
	var site_description = document
		.getElementById("settings[general][site_description]").value;
	var date_format = document
		.getElementById("settings[general][date_format]").options[document
		.getElementById("settings[general][date_format]").selectedIndex].value;
	var per_page_values = document
		.getElementById("settings[general][per_page_values]").value;

	xmlhttp.open("GET", ADMIN_REL_ROOT + "/query_print_panel.php?panel="
		+ panel + "&site_title=" + site_title + "&site_description="
		+ site_description + "&date_format=" + date_format
		+ "&per_page_values=" + per_page_values, true);
	break;

    case "post":
	var title = document.getElementById("settings[post][title]").value;
	var content = document.getElementById("settings[post][content]").value;
	var keywords = document.getElementById("settings[post][keywords]").value;

	xmlhttp.open("GET", ADMIN_REL_ROOT + "/query_print_panel.php?panel="
		+ panel + "&title=" + title + "&content=" + content
		+ "&keywords=" + keywords, true);
	break;

    case "add_user":
	var username = document.getElementById("settings[add_user][username]").value;
	var password = document.getElementById("settings[add_user][password]").value;
	var full_name = document
		.getElementById("settings[add_user][full_name]").value;
	var rights = document.getElementById("settings[add_user][rights]").value;
	/* TODO Checkboxes instead of manual entry of right codes */
	var twitter_user = document
		.getElementById("settings[add_user][twitter_user]").value;
	var facebook_user = document
		.getElementById("settings[add_user][facebook_user]").value;
	var google_plus_user = document
		.getElementById("settings[add_user][google_plus_user]").value;

	xmlhttp
		.open("GET", ADMIN_REL_ROOT + "/query_print_panel.php?panel="
			+ panel + "&username=" + username + "&password="
			+ password + "&full_name=" + full_name + "&rights="
			+ rights + "&twitter_user=" + twitter_user
			+ "&facebook_user=" + facebook_user
			+ "&google_plus_user=" + google_plus_user, true);
	break;
    }
    xmlhttp.send(); // Send HttpRequest
    return false;
}
/**
 * Delete a post from the database.
 * 
 * @param post_nr
 * @returns {Boolean}
 */
function deletePost(post_nr) {
    var confirmed = window
	    .confirm('Are you sure you want to delete this post?\nThis cannot be undone!');
    if (confirmed == true) {
	// Create HttpRequest
	var xmlhttp;
	xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() { // Handle HttpRequest
	    if (xmlhttp.readyState == 4) {
		if (xmlhttp.status == 200) {
		    showPopup(xmlhttp.responseText); // Show result
		} else {
		    showPopup("Error deleting post!");
		}
	    }
	};
	xmlhttp.open("GET", ADMIN_REL_ROOT + "/query_delete_post.php?post_nr="
		+ post_nr, true);
	xmlhttp.send(); // Send HttpRequest
	return false;
    }
}
/**
 * Stores the opacity of the popup.
 * @var {float}
 */
var popup_opacity = 1;
/**
 * Show a popup.
 * @param msg {String} The message to show 
 */
function showPopup(msg) {
    document.getElementById('popup_cell').innerHTML = msg;
    document.getElementById('popup_table').style.opacity = popup_opacity;
    document.getElementById('popup_table').style.filter = 'alpha(opacity='
	    + popup_opacity * 100 + ')';
    document.getElementById('popup_table').style.display = 'table';
    setTimeout('hidePopup()', 2000);
}
/**
 * Fade out the popup and hide it.
 */
function hidePopup() {
    if (popup_opacity > 0.1) {
	document.getElementById('popup_table').style.opacity = popup_opacity;
	document.getElementById('popup_table').style.filter = 'alpha(opacity='
		+ popup_opacity * 100 + ')';
	popup_opacity -= 0.1;
	setTimeout('hidePopup()', 50);
    } else {
	document.getElementById('popup_table').style.display = 'none';
	popup_opacity = 1;
    }
}
/**
 * Check for transition support.
 * 
 * @return {Boolean}
 */
function supportsTransitions() {
	var s = document.body.style;
	var supportsTransitions = 'transition' in s || 'WebkitTransition' in s
			|| 'MozTransition' in s || 'msTransition' in s
			|| 'OTransition' in s;
	return supportsTransitions;
}