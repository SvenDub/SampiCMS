/**
 * SampiCMS functions file. This file contains almost all functions that are
 * required to run SampiCMS properly.
 * 
 * @author Sven Dubbeld <sven.dubbeld1@gmail.com>
 * @package SampiCMS
 */
var REL_ROOT;
var ADMIN_REL_ROOT;
window.onload = function() {
    REL_ROOT = document.getElementsByName("REL_ROOT")[0].content;
    ADMIN_REL_ROOT = document.getElementsByName("ADMIN_REL_ROOT")[0].content;
};

function postComment() {
    var post_nr = document.getElementById("comment_post_form_post_nr").value;
    var author = document.getElementById("comment_post_form_author").value;
    var content = document.getElementById("comment_post_form_content").value;
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
		showPopup(xmlhttp.responseText); // Show result
		showComments(post_nr);
	    } else {
		showPopup("Error posting comment!");
	    }
	}
	;
    };
    xmlhttp.open("GET", REL_ROOT + "/sampi/query_post_comment.php?post_nr="
	    + post_nr + "&author=" + author + "&content=" + content, true);
    xmlhttp.send(); // Send HttpRequest
    return false;
}

var popup_opacity = 1;

function showComments(post_nr) {
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
		document.getElementById("comments_list").innerHTML = xmlhttp.responseText;
	    } else {
		showPopup("Error refreshing comments.");
	    }
	}
	;
    };
    xmlhttp.open("GET", REL_ROOT + "/sampi/query_show_comments.php?post_nr="
	    + post_nr, true);
    xmlhttp.send(); // Send HttpRequest
    return false;
}

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

function deletePost(post_nr) {
    var confirmed = window
	    .confirm('Are you sure you want to delete this post?\nThis cannot be undone!');
    if (confirmed == true) {
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
		    showPopup(xmlhttp.responseText); // Show result
		} else {
		    showPopup("Error deleting post!");
		}
	    }
	    ;
	};
	xmlhttp
		.open("GET", REL_ROOT
			+ "/sampi/admin/query_delete_post.php?post_nr="
			+ post_nr, true);
	xmlhttp.send(); // Send HttpRequest
	return false;
    }
}

function editPost(post_nr) {
    var title = document.getElementById("post_" + post_nr + "_header_title").innerHTML;
    var content = document.getElementById("post_" + post_nr + "_content").innerHTML;
    var keywords = document.getElementById("post_" + post_nr
	    + "_footer_keywords").innerHTML;
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
		showPopup(xmlhttp.responseText); // Show result
	    } else {
		showPopup("Error saving post!");
	    }
	}
	;
    };
    xmlhttp.open("GET", ADMIN_REL_ROOT + "/query_edit_post.php?post_nr="
	    + post_nr + "&title=" + title + "&content=" + content
	    + "&keywords=" + keywords, true);
    xmlhttp.send(); // Send HttpRequest
    return false;
}

function getUrlVars() {
    var map = {};
    var parts = window.location.search.replace(/[?&]+([^=&]+)(=[^&]*)?/gi,
	    function(m, key, value) {
		map[key] = (value === undefined) ? true : value.substring(1);
	    });
    return map;
}