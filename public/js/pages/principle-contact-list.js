$(document).ready(function(){
	// customer list page / add new contacts
	$('#principle_add_new_contacts').on('show.bs.modal', function (event) {
	  var button = $(event.relatedTarget) // Button that triggered the modal
	  var principle_name = button.data('name')
	  var principle_id = button.data('id')
	  var modal = $(this)
	  modal.find('.modal-body input#principle').val(principle_name)
	  modal.find('.modal-body input#principle_id').val(principle_id)
	});

	$("#save_contact").on('click',function(){
		if($("#add_new_contact").find("#name").val()){
			//var data = $("#add_new_contact").serialize();
			var formData = new FormData($("#add_new_contact")[0]);
			var url = $("#add_new_contact").attr('action');
			$.ajax({
				url: url,
		        type: 'POST',
		        data: formData,
		        processData: false,
				contentType: false,
				enctype: 'multipart/form-data',
		        success:function(response){
		        	if(response==1){
						$("#add_new_contact").find("#name").val('')
						$("#add_new_contact").find("#designation").val('')
						$("#add_new_contact").find("#job_field").val('')
						$("#add_new_contact").find("#phone").val('')
						$("#add_new_contact").find("#email").val('')

						$(".modal-body").find("#message_show_area").html('<div class="alert alert-success">\
				          <button class="close" data-dismiss="alert">×</button>\
				          <strong>Success!</strong> Contact Name Added\
				        </div>')
					}else{
						$(".modal-body").find("#message_show_area").html('<div class="alert alert-info">\
				          <button class="close" data-dismiss="alert">×</button>\
				          <strong>Info!</strong> Ops! something went wrong\
				        </div>')
					}
		        }
			})
		}else{
			$(".modal-body").find("#message_show_area").html('<div class="alert alert-error">\
		          <button class="close" data-dismiss="alert">×</button>\
		          <strong>Error!</strong> Contact Name Required\
		        </div>')
		}
		
	})

	$('#principle_add_new_contacts').on('hidden.bs.modal', function (event) {
	  location.reload();
	});

	// edit contact modal
	$('#principle_list_page_edit_contacts').on('show.bs.modal', function (event) {
	  var button = $(event.relatedTarget) // Button that triggered the modal
	  var id = button.data('id')
	  var name = button.data('name')
	  var designation = button.data('designation')
	  var job_field = button.data('field')
	  var phone = button.data('phone')
	  var email = button.data('email')
	  var modal = $(this)
	  modal.find('.modal-body input#id').val(id)
	  modal.find('.modal-body input#name').val(name)
	  modal.find('.modal-body input#designation').val(designation)
	  modal.find('.modal-body input#job_field').val(job_field)
	  modal.find('.modal-body input#phone').val(phone)
	  modal.find('.modal-body input#email').val(email)
	});
	// update contact
	$("#update_contact").on('click',function(){
		if($("#edit_contact").find("#name").val()){
			var url = $("#edit_contact").attr('action');

			//var data = $("#add_new_contact").serialize();
			var formData = new FormData($("#edit_contact")[0]);
			$.ajax({
				url: url,
		        type: 'POST',
		        data: formData,
		        processData: false,
				contentType: false,
				enctype: 'multipart/form-data',
		        success:function(response){
		        	if(response==1){
						$("#principle_list_page_edit_contacts .modal-body").find("#message_show_area").html('<div class="alert alert-success">\
				          <button class="close" data-dismiss="alert">×</button>\
				          <strong>Success!</strong> Contact Info Updated\
				        </div>')
					}else{
						$("#principle_list_page_edit_contacts.modal-body").find("#message_show_area").html('<div class="alert alert-info">\
				          <button class="close" data-dismiss="alert">×</button>\
				          <strong>Info!</strong> Ops! something went wrong\
				        </div>')
					}
		        }
			})
		}else{
			$("#principle_list_page_edit_contacts .modal-body").find("#message_show_area").html('<div class="alert alert-error">\
		          <button class="close" data-dismiss="alert">×</button>\
		          <strong>Error!</strong> Contact Name Required\
		        </div>')
		}
		
	})

	$('#principle_list_page_edit_contacts').on('hidden.bs.modal', function (event) {
	  location.reload();
	});
})