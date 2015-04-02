function update_div(update_div, with_report) {
	// Check user is still signed in first else redirect to login if they are update div with resp
	$.ajax({
		type: 'GET',
		url: '/includes/partial/form/check_session.php',
		data: $(this).serialize(),
		success: function(data) {
			if (data == 'false') {
					// session timed out redirect to login
					console.log('Session timed out, redirecting to login');
					window.location.replace("/login/login.php?return=/");
				}
			}
	});
	//usage: onclick="update_div('#div','report.php');"
	$.ajax({
		type: 'GET',
		url: '/includes/partial/'+with_report,
		data: $(this).serialize(),
		beforeSend: function() { $(update_div).html('<img src="/public/images/ICONS-spinny.gif" alt="loading" class="loading"/>'); },
		success: function(data) { $(update_div).html(data); },
		error: function() { $(update_div).html('error loading data, please refresh.'); }
	});
	console.log('updated ' + update_div + ' with ' + with_report);
	return false;
};
