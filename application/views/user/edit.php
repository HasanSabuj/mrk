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
        <form class="form-horizontal form-label-left" novalidate method="post" action="<?php echo base_url('user-update');?>" enctype="multipart/form-data">
        	<input type="hidden" name="id" value="<?=$data->id?>">
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="name" class="form-control col-md-7 col-xs-12" placeholder="both name(s) e.g Jon Doe" required="required" type="text" name="user_name" value="<?php echo $data->user_name;?>">
            </div>
          </div>
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="phone">Phone <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="phone" class="form-control col-md-7 col-xs-12" placeholder="Phone No." type="text" name="phone" value="<?php echo $data->phone;?>" required="required">
            </div>
          </div>
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="email" class="form-control col-md-7 col-xs-12" type="email" value="<?php echo $data->user_email;?>" readonly>
              <i>This email will be use in system authentication</i>
            </div>
          </div>
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pre_add">Present Address
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <textarea name="pre_add" placeholder="Present Address" class="form-control col-md-7 col-xs-12" ><?php echo $data->pre_add;?></textarea>
            </div>
          </div>
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="per_add">Permanent Address
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <textarea name="per_add" placeholder="Permanent Address" class="form-control col-md-7 col-xs-12" ><?php echo $data->per_add;?></textarea>
            </div>
          </div>
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="password">Password
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
            	<div class="input-group">
	              <input id="passwordx" class="form-control col-md-7 col-xs-12"  type="text" style="display: none;">
	              <input id="password" class="form-control col-md-7 col-xs-12"  type="password" name="password">
	              <span class="input-group-addon">
	               <span class="fa fa-eye" aria-hidden="true" id="show_password" style="display: block;"></span>
	              </span>
          		</div>
          		<i>Keep blank for unchange</i>
            </div>
          </div>

          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pic">Profile Picture
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="file" id="pck" class="form-control col-md-7 col-xs-12" name="profile_pic" accept="image/gif, image/jpeg, image/png">
            </div>
          </div>
          <?php
            if($data->profile_pic){
              $user_file='./public/uploads/user/'.$data->profile_pic;
              if(file_exists($user_file)){
                echo'<div class="col-xs-12 text-center">
                        <div class="thumbnail" style="max-width:128px;margin:auto;">
                          <div class="image view view-first">
                            <a href="'.base_url().'public/uploads/user/'.$data->profile_pic.'" download><img style="width: 100%; display: block;" src="'.base_url().'public/uploads/user/'.$data->profile_pic.'" alt="image" /></a>
                          </div>
                          <div class="caption">
                            <div class="checkbox">
                            <label style="padding-left:0px;">
                              <input type="checkbox" class="flat" name="delete_current"> Delete Current Image
                            </label>
                          </div>
                          </div>
                        </div>
                </div>';
                echo'<div class="clearfix"></div>';
              }
            }
          ?>
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="department">Department <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
            	<select name="department" required="required" class="form-control" id="department">
            		<option value="">Select Department</option>
		             <?php
		             	foreach ($departments as $value) {
		             		echo'<option value="'.$value->id.'" '.($value->id==$data->department?'selected':'').'>'.$value->name.'</option>';
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
		             		echo'<option value="'.$value->id.'" '.($value->id==$data->designation?'selected':'').'>'.$value->name.'</option>';
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
            			$selectedValue=$data->user_role;

            			if($this->session->userdata('userRole')==1){
            		?>
		             <option value="1" <?=($selectedValue==1?'selected':'')?>>Admin</option>
		             <option value="2" <?=($selectedValue==2?'selected':'')?>>Power User</option>
		             <option value="3" <?=($selectedValue==3?'selected':'')?>>User</option>
		             <?php
		         		}elseif($this->session->userdata('userRole')==2){
		         	?>
		         	 	<option value="2" <?=($selectedValue==2?'selected':'')?>>Power User</option>
		             	<option value="3" <?=($selectedValue==3?'selected':'')?>>User</option>
		         	<?php		
		         		}else{
		             ?>
		             <option value="3" <?=($selectedValue==3?'selected':'')?>>User</option>
		             <?php
						}
		             ?>
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
            			$selectedValue=$data->status;

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
            <div class="col-md-12 text-center">
              <button id="send" type="submit" class="btn btn-success">Update Now</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>