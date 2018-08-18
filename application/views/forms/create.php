<form action="<?=base_url('form-create')?>" method="post">
<div class="row">
	<div class="col-xs-12">
		<div class="form-group">
			<label>Form Name <span class="required">*</span>:</label>
			<input type="text" name="name" required class="form-control">
		</div>
	</div>
	<div class="col-xs-12">
		<input type="button" id="add_element" class="btn btn-success" value="Add Element"> &nbsp;&nbsp;&nbsp;
		<input type="button" id="delete_element" class="btn btn-danger" value="Delete Element" onclick="remove_last_tr();">
	</div>
	<div class="col-xs-12">
		<table id="result_table" class="table">
			<tbody>
				
			</tbody>
		</table>
	</div>
	<div class="col-xs-12 text-center">
		<input class="btn btn-success" type="submit" name="save" value="Save">
	</div>
</div>
</form>