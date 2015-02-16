function update_div(update_div, with_report) {
	//EG onclick="update_div('#div','report.php');"
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
