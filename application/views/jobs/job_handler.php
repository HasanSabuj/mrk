<div class="row">
	<div class="col-xs-12">
		<div class="x_panel">
	      <div class="x_title">
	        <a href="<?=base_url('job-list')?>" class="btn btn-primary btn-xs">Back</a>   
	        <ul class="nav navbar-right panel_toolbox">
	          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
	          </li>
	          <li><a class="close-link"><i class="fa fa-close"></i></a>
	          </li>
	        </ul>
	        <div class="clearfix"></div>
	      </div>
	      <div class="x_content">
	      		<form method="post" action="<?=base_url('job-handler-save')?>" class="form-horizontal form-label-left" novalidate>
	      			<input type="hidden" name="job" value="<?=$handler->id?>">
	      			<div class="item form-group">
			            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="corresponding">Corresponding Handler <span class="required">*</span></label>
			            <div class="col-md-6 col-sm-6 col-xs-12">
			            	<select name="co_handler" class="form-control col-md-7 col-xs-12" required id="corresponding">
		      					<option value="">Select One</option>
		      					<?php
		      						foreach($users as $k=>$val){
		      							echo'<option value="'.$val["id"].'" '.($val["id"]==$handler->co_handler?'selected':'').'>'.$val["user_name"].' ('.$val["des_name"].')</option>';
		      						}
		      					?>
		      				</select>
			            </div>
			        </div>
	      			<div class="item form-group">
			            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="marketing">Marketing Handler <span class="required">*</span></label>
			            <div class="col-md-6 col-sm-6 col-xs-12">
			            	<select name="ma_handler" class="form-control" required id="marketing">
		      					<option value="">Select One</option>
		      					<?php
		      						foreach($users as $k=>$val){
		      							echo'<option value="'.$val["id"].'" '.($val["id"]==$handler->ma_handler?'selected':'').'>'.$val["user_name"].' ('.$val["des_name"].')</option>';
		      						}
		      					?>
		      				</select>
			            </div>
			        </div>
			        <div class="item form-group">
			            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="design">Design Handler </label>
			            <div class="col-md-6 col-sm-6 col-xs-12">
			            	<select name="de_handler" class="form-control" id="design">
		      					<option value="">Select One</option>
		      					<?php
		      						foreach($users as $k=>$val){
		      							echo'<option value="'.$val["id"].'" '.($val["id"]==$handler->de_handler?'selected':'').'>'.$val["user_name"].' ('.$val["des_name"].')</option>';
		      						}
		      					?>
		      				</select>
			            </div>
			        </div>
	      			<div class="ln_solid"></div>
			          <div class="form-group">
			            <div class="col-md-6 col-md-offset-3">
			              <input id="send" type="submit" class="btn btn-success" name="save" value="Save"/>
			            </div>
			          </div>
	      		</form>
	      </div>
		</div>
	</div>
</div>