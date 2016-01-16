
$(document).ready(function(){
	$('[data-toggle="tooltip"]').tooltip();

	if($.fn.select2){

		$('.select2').select2({
			tags: true,
			tokenSeparators: [',', ' '],
			minimumResultsForSearch: -1,
		});
	}

	if($.fn.multiselect){
		
		$('.multiselectinit').multiselect({
			buttonWidth: '1000px'
		});
	}

	if($.fn.daterangepicker){
	
		$(".date").daterangepicker({ singleDatePicker:true}, function(start, end, label){

			console.log(start.toISOString(), end.toISOString(), label);

		});
	}

		
});

function loadpopup(ps_id, ps_url, po_data, pf_callback){

	closepopup();

	$('body').append('<div class="modal fade loadedpopup" id="'+ps_id+'"><div class="modal-dialog"></div></div>');

	$(".modal-dialog").load(ps_url, po_data, function(ps_result){

	    $('#'+ps_id).modal('show');

	    if ($.isFunction(window[pf_callback])) {
		  window[pf_callback]();
		}
	});

	$("#"+ps_id).on('hidden.bs.modal', function () {
	    $(this).data('bs.modal', null);
	    closepopup();
	});
}

function closepopup() {
	$('.loadedpopup').remove();
}


