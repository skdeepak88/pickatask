$(document).ready(function(){

	$(document).on('click', '.checkcriteria', configurecriteria);

	$(document).on('click', '.picktask', picktask);

});


function configurecriteria() {

	lb_checked = $(this).is(':checked');
	li_criteria = $(this).val();
	li_accountid = $(this).data('accountid');

	lo_request = {};
	lo_request.a = lb_checked ? 'addcriteria' : 'removecriteria';
	lo_request.i = li_accountid;
	lo_request.c = li_criteria;

	$.getJSON('/process-account', lo_request, function(lo_response){

	});
}

function picktask() {

	ls_taskhash = $(this).data('hash');

	lo_request = {};
	lo_request.a = 'picktask';
	lo_request.h = ls_taskhash;

	loadpopup('chooseaccount', '/popup-choose-account', lo_request);

	// $.getJSON('/process-task', lo_request, function(lo_response){

	// 	if(lo_response.chooseaccount)
	// 		loadpopup('chooseaccount', '/popup-choose-account', lo_request);
	// });
}