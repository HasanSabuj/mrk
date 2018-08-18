<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <?php if($this->session->userdata('permissions')->user_list==1):?>
        <a class="btn btn-primary btn-xs" href="<?php echo base_url('user-list');?>"><i class="fa fa-users"></i> User List</a>
      <?php endif;?>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
          </li>
          <li><a class="close-link"><i class="fa fa-close"></i></a>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <form class="form-horizontal form-label-left" novalidate method="post" action="<?php echo base_url('user-insert');?>" enctype="multipart/form-data">
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="name" class="form-control col-md-7 col-xs-12" placeholder="both name(s) e.g Jon Doe" required="required" type="text" name="user_name" value="<?php echo set_value('user_name');?>">
            </div>
          </div>
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="phone">Phone <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="phone" class="form-control col-md-7 col-xs-12" placeholder="Phone No." type="text" name="phone" value="<?php echo set_value('phone');?>" required="required">
            </div>
          </div>
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="email" class="form-control col-md-7 col-xs-12" type="email" value="<?php echo set_value('user_email');?>" required="required" name="user_email">
              <i>This email will be use in system authentication</i>
            </div>
          </div>
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pre_add">Present Address
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <textarea name="pre_add" placeholder="Present Address" class="form-control col-md-7 col-xs-12" ><?php echo set_value('pre_add');?></textarea>
            </div>
          </div>
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="per_add">Permanent Address
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <textarea name="per_add" placeholder="Permanent Address" class="form-control col-md-7 col-xs-12" ><?php echo set_value('per_add');?></textarea>
            </div>
          </div>
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="password">Password <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
            	<div class="input-group">
	              <input id="password" class="form-control col-md-7 col-xs-12"  type="password" name="password" required="required">
	              <span class="input-group-addon">
	               <span class="fa fa-eye" aria-hidden="true" id="show_password"></span>
	              </span>
          		</div>
            </div>
          </div>

          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pic">Profile Picture
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="file" id="pck" class="form-control col-md-7 col-xs-12" name="profile_pic" accept="image/gif, image/jpeg, image/png">
            </div>
          </div>

          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="department">Department <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
            	<select name="department" required="required" class="form-control" id="department">
            		<option value="">Select Department</option>
		             <?php
		             	foreach ($departments as $value) {
		             		echo'<option value="'.$value->id.'" '.($value->id==set_value('department')?'selected':'').'>'.$value->name.'</option>';
		             	}
		             ?>
            	</select>
            </div>
          </div>
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="designation">Designation <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
            	<select name="designation" required="required" class="form-control" id="designation">
            		<option value="">Select Designation</option>
		             <?php
		             	foreach ($designations as $value) {
		             		echo'<option value="'.$value->id.'" '.($value->id==set_value('designation')?'selected':'').'>'.$value->name.'</option>';
		             	}
		             ?>
            	</select>
            </div>
          </div>
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="user_role">User Role <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
            	<select name="user_role" required="required" class="form-control" id="user_role">
            		<option value="">Select User Role</option>
            		<?php
            			$selectedValue=set_value('user_role');

            			if($this->session->userdata('userRole')==1){
            		?>
		             <option value="1" <?=($selectedValue==1?'selected':'')?>>Admin</option>
		             <option value="2" <?=($selectedValue==2?'selected':'')?>>Power User</option>
		            <?php
		            }
		            ?> 
		             <option value="3" <?=($selectedValue==3?'selected':'')?>>User</option>

            	</select>
            </div>
          </div>

          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="status">User Status <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
            	<select name="status" required="required" class="form-control" id="status">
            		<option value="">Select User Status</option>
            		<?php
            			$selectedValue=set_value('status');

            			if($this->session->userdata('userRole')==1 or $this->session->userdata('userRole')==2){
            		?>
		             <option value="1" <?=($selectedValue==1?'selected':'')?>>Active</option>
		            <?php
		            }
		            ?> 
		             <option value="2" <?=($selectedValue==2?'selected':'')?>>Inactive</option>

            	</select>
            </div>
          </div>

          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-6 col-md-offset-3">
              <button id="send" type="submit" class="btn btn-success">Add Now</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>