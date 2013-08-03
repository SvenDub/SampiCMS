/**
 * SampiCMS admin functions file. This file contains almost all functions that
 * are required to run the administration module of SampiCMS properly.
 * 
 * @author Sven Dubbeld <sven.dubbeld1@gmail.com>
 * @package SampiCMS\Admin
 */
var REL_ROOT;
var ADMIN_REL_ROOT;
window.onload = function() {
    REL_ROOT = document.getElementsByName("REL_ROOT")[0].content;
    ADMIN_REL_ROOT = document.getElementsByName("ADMIN_REL_ROOT")[0].content;
};

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
    if (window.XMLHttpRequest) { // IE7+, Firefox, Chrome, Opera, Safari
	xmlhttp = new XMLHttpRequest();
    } else { // IE6, IE5
	xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() { // Handle HttpRequest
	if (xmlhttp.readyState == 4) {
	    if (xmlhttp.status == 200) {
		panelDiv.innerHTML = xmlhttp.responseText;
		showPopup("Saving...");
	    } else {
		showPopup("An error occured while saving. Please try again.");
	    }
	}
	;
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
		+ panel + "&title=" + title + "&content=" + content + "&keywords=" + keywords, true);
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

var popup_opacity = 1;

function showPopup(msg) {
    document.getElementById('popup_cell').innerHTML = msg;
    document.getElementById('popup_table').style.opacity = popup_opacity;
    document.getElementById('popup_table').style.filter = 'alpha(opacity='
	    + popup_opacity * 100 + ')';
    document.getElementById('popup_table').style.display = 'table';
    setTimeout('hidePopup()', 2000);
}

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