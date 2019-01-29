$(function() {
	$('.target-success').animate({opacity: 1.0}, 800).fadeOut("slow");

	var doc = $(document);
	var linkUrl = '';
	var linkId = '';

	if(window.location.pathname === '/admin/timetable/index') {
		linkUrl = '/admin/timetable/create' + window.location.search;
		linkId = '#timetable-date';
		doc.on('click', '.fc-day', function() {
			var date = $(this).data('date');
			$.ajax({
				url: '/admin/timetable/create' + window.location.search,
				method: "POST", 
				data: { 
		 			date: date
				},
				success: function(data) {
	         		$('#w0').modal('show')
	         		.find('#modal-add')
	         		.html(data);
	         		$(linkId).val(date);
 				}
			});
		});

		doc.on('click', '.fc-end', function(){
		 	var link = $(this).data('target');
			$.ajax({
				url: link,
				method: "POST", 
				success: function(data) {
	         		$('#w0').modal('show')
	         		.find('#modal-add')
	         		.html(data);
 				}
			});
		});
	}

	if(window.location.pathname === '/timetable/view') {
		doc.on('click', '.fc-event', function() { 
			var link = $(this).data('target');
			$.ajax({
				url: link,
				method: "POST", 
				success: function(data) {
	         		$('#w1').modal('show')
	         		.find('#modal-add')
	         		.html(data);
 				}
			});
		});
	}

	doc.on('click', '.timetable-detail', function() { 
		var link = $(this).data('target');
		$.ajax({
			url: link,
			method: "POST", 
			success: function(data) {
	     		$('#w0').modal('show')
	     		.find('#modal-add')
	     		.html(data);
			}
		});
	});

	doc.on('click', '.form-action', function() { 
		var link = $(this).data('target');
		$.ajax({
			url: link,
			method: "POST", 
			success: function(data) {
	     		$('#w0').modal('show')
	     		.find('#modal-add')
	     		.html(data);
			}
		});
	});

	doc.on('click', '.stat-record .pagination li a', function() { 
	 	$("#modal-add").load($(this).attr('href'));
		return false;
	});

});