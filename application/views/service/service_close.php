<div class="row">
	<div class="col-xs-12">
		<div class="x_panel">
	      <div class="x_title">
	        <a href="<?=base_url('service-list')?>" class="btn btn-primary btn-xs">Back</a>   
	        <ul class="nav navbar-right panel_toolbox">
	          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
	          </li>
	          <li><a class="close-link"><i class="fa fa-close"></i></a>
	          </li>
	        </ul>
	        <div class="clearfix"></div>
	      </div>
	      <div class="x_content">
	      		<form method="post" action="<?=base_url('service-close')?>" novalidate>
	      			<input type="hidden" name="service" value="<?=$service?>">
	      			<div class="form-group">
			            <label for="close_note">Service Close Note<span class="required">*</span></label>
			            <textarea id="close_note" name="close_note" class="form-control" required><?=$service_details->close_note?></textarea>
			        </div>
			        <!--<div class="form-group">
			            <label for="flag">Service Sign<span class="required">*</span></label>
			            <select name="flag">
			            	<option value="1">Win</option>
			            	<option value="2">Loss</option>
			            </select>
			        </div>-->
	      			<div class="ln_solid"></div>
			          <div class="form-group">
			            <div class="col-xs-12">
			              <input id="send" type="submit" class="btn btn-success" name="save" value="Close This Service"/>
			            </div>
			          </div>
	      		</form>
	      </div>
		</div>
	</div>
</div>