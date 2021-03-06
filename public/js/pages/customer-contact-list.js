$(document).ready(function(){
	// customer list page / add new contacts
	$('#customer_list_page_add_new_contacts').on('show.bs.modal', function (event) {
	  var button = $(event.relatedTarget) // Button that triggered the modal
	  var customer_name = button.data('name')
	  var customer_id = button.data('id')
	  var modal = $(this)
	  modal.find('.modal-body input#customer').val(customer_name)
	  modal.find('.modal-body input#customer_id').val(customer_id)
	});

	$("#save_contact").on('click',function(){
		if($("#add_new_contact").find("#name").val()){
			var formData = new FormData($("#add_new_contact")[0]);
			var url = $("#add_new_contact").attr('action');

			$.ajax({
                url: url,
                dataType: "text",
                cache: false,
                contentType: false,
                processData: false,
                data: formData,                         
                type: "post",
                success: function(response){
	                if(response==1){
						$("#add_new_contact").find("#name").val('')
						$("#add_new_contact").find("#department").val('')
						$("#add_new_contact").find("#designation").val('')
						$("#add_new_contact").find("#phone").val('')
						$("#add_new_contact").find("#email").val('')
						$("#add_new_contact").find("#file").val('')

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
             });
		}else{
			$(".modal-body").find("#message_show_area").html('<div class="alert alert-error">\
		          <button class="close" data-dismiss="alert">×</button>\
		          <strong>Error!</strong> Contact Name Required\
		        </div>')
		}
		
	})

	$('#customer_list_page_add_new_contacts').on('hidden.bs.modal', function (event) {
	  location.reload();
	});

	// edit contact modal
	$('#customer_list_page_edit_contacts').on('show.bs.modal', function (event) {
	  var button = $(event.relatedTarget) // Button that triggered the modal
	  var id = button.data('id')
	  var name = button.data('name')
	  var department = button.data('department')
	  var designation = button.data('designation')
	  var phone = button.data('phone')
	  var email = button.data('email')
	  var modal = $(this)
	  modal.find('.modal-body input#id').val(id)
	  modal.find('.modal-body input#name').val(name)
	  modal.find('.modal-body input#department').val(department)
	  modal.find('.modal-body input#designation').val(designation)
	  modal.find('.modal-body input#phone').val(phone)
	  modal.find('.modal-body input#email').val(email)
	});
	// update contact
	$("#update_contact").on('click',function(){
		if($("#edit_contact").find("#name").val()){
			var url = $("#edit_contact").attr('action');
			var formData = new FormData($("#edit_contact")[0]);
			

			$.ajax({
                url: url,
                dataType: "text",
                cache: false,
                contentType: false,
                processData: false,
                data: formData,                         
                type: "post",
                success: function(response){
	                if(response==1){
						$("#customer_list_page_edit_contacts .modal-body").find("#message_show_area").html('<div class="alert alert-success">\
				          <button class="close" data-dismiss="alert">×</button>\
				          <strong>Success!</strong> Contact Info Updated\
				        </div>');
				        $("#edit_contact").find("#file").val('');
					}else{
						$("#customer_list_page_edit_contacts.modal-body").find("#message_show_area").html('<div class="alert alert-info">\
				          <button class="close" data-dismiss="alert">×</button>\
				          <strong>Info!</strong> Ops! something went wrong\
				        </div>')
					}
                }
             });

		}else{
			$("#customer_list_page_edit_contacts .modal-body").find("#message_show_area").html('<div class="alert alert-error">\
		          <button class="close" data-dismiss="alert">×</button>\
		          <strong>Error!</strong> Contact Name Required\
		        </div>')
		}
		
	})

	$('#customer_list_page_edit_contacts').on('hidden.bs.modal', function (event) {
	  location.reload();
	});
})