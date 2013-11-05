/**
 * SampiCMS setup functions file.
 * 
 * This file contains almost all functions that are required to run the setup of
 * SampiCMS properly.
 * 
 * @author Sven Dubbeld <sven.dubbeld1@gmail.com>
 */
var REL_ROOT;
var ADMIN_REL_ROOT;
/**
 * JavaScript functions to execute on page load.
 * 
 * Get the relative (web) roots of SampiCMS and the admin interface. Also loads
 * first step of setup.
 */
window.onload = function() {
	REL_ROOT = document.getElementsByName("REL_ROOT")[0].content;
	ADMIN_REL_ROOT = document.getElementsByName("ADMIN_REL_ROOT")[0].content;
	switch (window.location.hash) {
		case "#step_1":
			loadSetupStep(1);
			break;
		case "#step_2":
			loadSetupStep(2);
			break;
		case "#step_3":
			loadSetupStep(3);
			break;
		case "#step_4":
			loadSetupStep(4);
			break;
		case "#step_5":
			loadSetupStep(5);
			break;
		default:
			setTimeout(function() {
				loadSetupStep(1);
			}, 500);
	}
};
/**
 * JavaScript functions to execute when the hash changes.
 * 
 * Navigate to other step.
 */
window.onhashchange = function() {
	switch (window.location.hash) {
		case "#step_1":
			loadSetupStep(1);
			break;
		case "#step_2":
			loadSetupStep(2);
			break;
		case "#step_3":
			loadSetupStep(3);
			break;
		case "#step_4":
			loadSetupStep(4);
			break;
		case "#step_5":
			loadSetupStep(5);
			break;
		default:
			setTimeout(function() {
				loadSetupStep(1);
			}, 500);
	}
};
/**
 * Load a step of the setup.
 * 
 * @param step
 */
function loadSetupStep(step) {
	function transition() {
		// Create HttpRequest
		var xmlhttp;
		xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() { // Handle HttpRequest
			if (xmlhttp.readyState == 4) {
				if (xmlhttp.status == 200) {
					document.getElementById("setup_body").innerHTML = xmlhttp.responseText;
					// window.location.hash = "step_" + step;
					switch (true) {
						case step == 5:
							document.getElementById("setup_footer_5").style.borderBottom = "#44BBFF solid 5px";
						case step == 4:
							document.getElementById("setup_footer_4").style.borderBottom = "#44BBFF solid 5px";
						case step == 3:
							document.getElementById("setup_footer_3").style.borderBottom = "#44BBFF solid 5px";
						case step == 2:
							document.getElementById("setup_footer_2").style.borderBottom = "#44BBFF solid 5px";
							break;
						default:
					}
				} else {
					document.getElementById("setup_body").innerHTML = "Error loading this step. Please refresh to try again.";
				}
				if (supportsTransitions()) {
					document.getElementById("setup_body").removeEventListener(
							"transitionend", transition, true);
					document.getElementById("setup_body").style.opacity = "1";
				}
			}
		};
		xmlhttp.open("GET", ADMIN_REL_ROOT + "/query_load_setup_step.php?step="
				+ step, true);
		xmlhttp.send(); // Send HttpRequest
	}
	if (supportsTransitions()) {
		document.getElementById("setup_body").style.opacity = "0";
		document.getElementById("setup_body").addEventListener("transitionend",
				transition, true);
	} else {
		transition();
	}
}
/**
 * Check a step of the setup.
 * 
 * @param step
 */
function checkSetupStep(step) {
	checkSetupStep(step, false);
}
/**
 * Check a step of the setup and submit it if the second parameter is true.
 * 
 * @param step
 * @param submit
 */
function checkSetupStep(step, submit) {
	switch (step) {
		case 2:
			hostname = document.getElementById("db_host");
			database = document.getElementById("db");
			username = document.getElementById("db_user");
			password = document.getElementById("db_pass");

			// Create HttpRequest
			var xmlhttp;
			xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() { // Handle HttpRequest
				if (xmlhttp.readyState == 4) {
					if (xmlhttp.status == 200) {
						var json = xmlhttp.responseText;
						var jsonDecoded = JSON.parse(json);
						document.getElementById("setup_msg").innerHTML = jsonDecoded.msg;
						if (jsonDecoded.code == 0) {
							if (submit) {
								var xmlhttpSubmit;
								xmlhttpSubmit = new XMLHttpRequest();
								xmlhttpSubmit.onreadystatechange = function() { // Handle
																				// HttpRequest
									if (xmlhttpSubmit.readyState == 4) {
										if (xmlhttpSubmit.status == 200) {
											var jsonSubmit = xmlhttpSubmit.responseText;
											var jsonSubmitDecoded = JSON
													.parse(jsonSubmit);
											document
													.getElementById("setup_msg").innerHTML += jsonSubmitDecoded.msg;
											if (jsonSubmitDecoded.code == 0) {
												setTimeout(
														function() {
															window.location.hash = "#step_3";
														}, 1000);
											}
										} else {
											document
													.getElementById("setup_msg").innerHTML = "<span style='color:red;'>Error submiting data. Please try again.</span>";
										}
									}

								};
								xmlhttpSubmit.open("GET", ADMIN_REL_ROOT
										+ "/query_save_setup_step.php?step="
										+ step + "&db_host=" + hostname.value
										+ "&db=" + database.value + "&db_user="
										+ username.value + "&db_pass="
										+ password.value, true);
								xmlhttpSubmit.send(); // Send HttpRequest
							}
						}
					} else {
						document.getElementById("setup_msg").innerHTML = "<span style='color:red;'>Error submiting data. Please try again.</span>";
					}
				}
			};
			xmlhttp.open("GET", ADMIN_REL_ROOT
					+ "/query_check_setup_step.php?step=" + step + "&db_host="
					+ hostname.value + "&db=" + database.value + "&db_user="
					+ username.value + "&db_pass=" + password.value, true);
			xmlhttp.send(); // Send HttpRequest

			break;
		case 3:
			site_title = document.getElementById("site_title");
			site_description = document.getElementById("site_description");
			date_format = document.getElementById("date_format");

			// Create HttpRequest
			var xmlhttp;
			xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() { // Handle HttpRequest
				if (xmlhttp.readyState == 4) {
					if (xmlhttp.status == 200) {
						var json = xmlhttp.responseText;
						var jsonDecoded = JSON.parse(json);
						document.getElementById("setup_msg").innerHTML = jsonDecoded.msg;
						if (jsonDecoded.code == 0) {
							if (submit) {
								var xmlhttpSubmit;
								xmlhttpSubmit = new XMLHttpRequest();
								xmlhttpSubmit.onreadystatechange = function() { // Handle
																				// HttpRequest
									if (xmlhttpSubmit.readyState == 4) {
										if (xmlhttpSubmit.status == 200) {
											var jsonSubmit = xmlhttpSubmit.responseText;
											var jsonSubmitDecoded = JSON
													.parse(jsonSubmit);
											document
													.getElementById("setup_msg").innerHTML += jsonSubmitDecoded.msg;
											if (jsonSubmitDecoded.code == 0) {
												setTimeout(
														function() {
															window.location.hash = "#step_4";
														}, 1000);
											}
										} else {
											document
													.getElementById("setup_msg").innerHTML = "<span style='color:red;'>Error submiting data. Please try again.</span>";
										}
									}

								};
								xmlhttpSubmit.open("GET", ADMIN_REL_ROOT
										+ "/query_save_setup_step.php?step="
										+ step + "&site_title="
										+ site_title.value
										+ "&site_description="
										+ site_description.value
										+ "&date_format=" + date_format.value,
										true);
								xmlhttpSubmit.send(); // Send HttpRequest
							}
						}
					} else {
						document.getElementById("setup_msg").innerHTML = "<span style='color:red;'>Error submiting data. Please try again.</span>";
					}
				}
			};
			xmlhttp.open("GET", ADMIN_REL_ROOT
					+ "/query_check_setup_step.php?step=" + step
					+ "&site_title=" + site_title.value + "&site_description="
					+ site_description.value + "&date_format="
					+ date_format.value, true);
			xmlhttp.send(); // Send HttpRequest

			break;
		case 4:
			username = document.getElementById("username");
			password = document.getElementById("password");
			full_name = document.getElementById("full_name");
			twitter_user = document.getElementById("twitter_user");
			facebook_user = document.getElementById("facebook_user");
			google_plus_user = document.getElementById("google_plus_user");

			// Create HttpRequest
			var xmlhttp;
			xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() { // Handle HttpRequest
				if (xmlhttp.readyState == 4) {
					if (xmlhttp.status == 200) {
						var json = xmlhttp.responseText;
						var jsonDecoded = JSON.parse(json);
						document.getElementById("setup_msg").innerHTML = jsonDecoded.msg;
						if (jsonDecoded.code == 0) {
							if (submit) {
								var xmlhttpSubmit;
								xmlhttpSubmit = new XMLHttpRequest();
								xmlhttpSubmit.onreadystatechange = function() { // Handle
																				// HttpRequest
									if (xmlhttpSubmit.readyState == 4) {
										if (xmlhttpSubmit.status == 200) {
											var jsonSubmit = xmlhttpSubmit.responseText;
											var jsonSubmitDecoded = JSON
													.parse(jsonSubmit);
											document
													.getElementById("setup_msg").innerHTML += jsonSubmitDecoded.msg;
											if (jsonSubmitDecoded.code == 0) {
												setTimeout(
														function() {
															window.location.hash = "#step_5";
														}, 1000);
											}
										} else {
											document
													.getElementById("setup_msg").innerHTML = "<span style='color:red;'>Error submiting data. Please try again.</span>";
										}
									}

								};
								xmlhttpSubmit.open("GET", ADMIN_REL_ROOT
										+ "/query_save_setup_step.php?step="
										+ step + "&username=" + username.value
										+ "&password=" + password.value
										+ "&full_name=" + full_name.value
										+ "&twitter_user=" + twitter_user.value
										+ "&facebook_user="
										+ facebook_user.value
										+ "&google_plus_user="
										+ google_plus_user.value, true);
								xmlhttpSubmit.send(); // Send HttpRequest
							}
						}
					} else {
						document.getElementById("setup_msg").innerHTML = "<span style='color:red;'>Error submiting data. Please try again.</span>";
					}
				}
			};
			xmlhttp.open("GET", ADMIN_REL_ROOT
					+ "/query_check_setup_step.php?step=" + step + "&username="
					+ username.value + "&password=" + password.value
					+ "&full_name=" + full_name.value + "&twitter_user="
					+ twitter_user.value + "&facebook_user="
					+ facebook_user.value + "&google_plus_user="
					+ google_plus_user.value, true);
			xmlhttp.send(); // Send HttpRequest
		case 5:
			// Create HttpRequest
			var xmlhttp;
			xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() { // Handle HttpRequest
				if (xmlhttp.readyState == 4) {
					if (xmlhttp.status == 200) {
						var json = xmlhttp.responseText;
						var jsonDecoded = JSON.parse(json);
						document.getElementById("setup_msg").innerHTML = jsonDecoded.msg;
						if (jsonDecoded.code == 0) {
							if (submit) {
								var xmlhttpSubmit;
								xmlhttpSubmit = new XMLHttpRequest();
								xmlhttpSubmit.onreadystatechange = function() { // Handle
																				// HttpRequest
									if (xmlhttpSubmit.readyState == 4) {
										if (xmlhttpSubmit.status == 200) {
											var jsonSubmit = xmlhttpSubmit.responseText;
											var jsonSubmitDecoded = JSON
													.parse(jsonSubmit);
											document
													.getElementById("setup_msg").innerHTML += jsonSubmitDecoded.msg;
											if (jsonSubmitDecoded.code == 0) {
												setTimeout(
														function() {
															window.location = REL_ROOT;
														}, 1000);
											}
										} else {
											document
													.getElementById("setup_msg").innerHTML = "<span style='color:red;'>Error submiting data. Please try again.</span>";
										}
									}

								};
								xmlhttpSubmit.open("GET", ADMIN_REL_ROOT
										+ "/query_save_setup_step.php?step=" + step, true);
								xmlhttpSubmit.send(); // Send HttpRequest
							}
						}
					} else {
						document.getElementById("setup_msg").innerHTML = "<span style='color:red;'>Error submiting data. Please try again.</span>";
					}
				}
			};
			xmlhttp.open("GET", ADMIN_REL_ROOT
					+ "/query_check_setup_step.php?step=" + step, true);
			xmlhttp.send(); // Send HttpRequest
	}
}