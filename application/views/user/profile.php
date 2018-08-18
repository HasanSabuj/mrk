<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2><small>Update personal information</small></h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
          </li>
          <li><a class="close-link"><i class="fa fa-close"></i></a>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <form class="form-horizontal form-label-left" novalidate method="post" action="<?php echo base_url('profile');?>" enctype="multipart/form-data">
          <input type="hidden" id="id" name="id" value="<?=$user_info->id?>">
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="name" class="form-control col-md-7 col-xs-12" placeholder="both name(s) e.g Jon Doe" required="required" type="text" name="user_name" value="<?php echo $user_info->user_name;?>">
            </div>
          </div>
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="phone">Phone
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="phone" class="form-control col-md-7 col-xs-12" placeholder="Phone No." type="text" name="phone" value="<?php echo $user_info->phone;?>">
            </div>
          </div>
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="email" class="form-control col-md-7 col-xs-12" type="text" readonly="" value="<?php echo $user_info->user_email;?>">
            </div>
          </div>
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="epassword">e Password <small>(for email service)</small>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="epassword" class="form-control col-md-7 col-xs-12"  type="text" name="pw_2" >
              <i>Keep blank for unchange</i>
            </div>
          </div>
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pre_add">Present Address
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <textarea name="pre_add" placeholder="Present Address" class="form-control col-md-7 col-xs-12" ><?php echo $user_info->pre_add;?></textarea>
            </div>
          </div>
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="per_add">Permanent Address
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <textarea name="per_add" placeholder="Permanent Address" class="form-control col-md-7 col-xs-12" ><?php echo $user_info->per_add;?></textarea>
            </div>
          </div>
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="password">Password
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="password" class="form-control col-md-7 col-xs-12"  type="text" name="password" >
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
            if($user_info->profile_pic){
              $user_file='./public/uploads/user/'.$user_info->profile_pic;
              if(file_exists($user_file)){
                echo'<div class="col-xs-12 text-center">
                        <div class="thumbnail" style="max-width:128px;margin:auto;">
                          <div class="image view view-first">
                            <a href="'.base_url().'public/uploads/user/'.$user_info->profile_pic.'" download><img style="width: 100%; display: block;" src="'.base_url().'public/uploads/user/'.$user_info->profile_pic.'" alt="image" /></a>
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
          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-6 col-md-offset-3">
              <button id="send" type="submit" class="btn btn-success">Update</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>