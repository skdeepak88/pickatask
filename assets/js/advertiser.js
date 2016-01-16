$(document).ready(function(){

	$(document).on('click', '.checkcriteria', configurecriteria);

	$(document).on('click', '.addblogpostlink', addblogpostlink);
	$(document).on('click', '.removeblogpostlink', removeblogpostlink);

});


function configurecriteria() {

	lb_checked = $(this).is(':checked');
	li_criteria = $(this).val();
	li_taskid = $(this).data('taskid');

	lo_request = {};
	lo_request.a = lb_checked ? 'addcriteria' : 'removecriteria';
	lo_request.i = li_taskid;
	lo_request.c = li_criteria;

	$.getJSON('/process-task', lo_request, function(lo_response){

	});
}


function addblogpostlink(e) {

	e.preventDefault();

	ls_linktext = $('input[name="linktext"]').val();
	ls_linkurl = $('input[name="linkurl"]').val();
	li_taskid = $(this).data('taskid');

	lo_request = {};
	lo_request.a = 'addblogpostlink';
	lo_request.i = li_taskid;
	lo_request.t = ls_linktext;
	lo_request.l = ls_linkurl;
	
	$.getJSON('/process-task', lo_request, function(lo_response){
		
		$(".partial-task-links").html(lo_response.content);

		$('input[name="linktext"]').val('');
		$('input[name="linkurl"]').val('');

	});
}

function removeblogpostlink(e) {

	e.preventDefault();

	li_taskassetid = $(this).data('id');

	lo_request = {};
	lo_request.a = 'removeblogpostlink';
	lo_request.t = li_taskassetid;
	
	$.getJSON('/process-task', lo_request, function(lo_response){
		
		$(".partial-task-links").html(lo_response.content);

	});
}

