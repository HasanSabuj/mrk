<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <?php if($this->session->userdata('permissions')->principle_list==1):?>
        <a class="btn btn-primary btn-xs" href="<?php echo base_url('principle-list');?>"><i class="fa fa-list"></i> Principle List</a>
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
        <form class="form-horizontal form-label-left" method="post" action="<?php echo base_url('principle-update');?>" enctype="multipart/form-data">
        	<input type="hidden" name="id" value="<?=$principle->id?>">
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="name" class="form-control col-md-7 col-xs-12" required="required" type="text" name="name" value="<?php echo $principle->name;?>">
            </div>
          </div>
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="products">product <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <div style="max-height: 250px;overflow: auto;">
                <?php
                  $existing=array();
                  if($principle->products){
                  	$existing=explode(',', $principle->products);
                  }	
                  foreach ($products as $key => $value) {
                    //echo "<option value='".$value->id."''>".$value->name."</option>";
                    echo'<label>
                      <input type="checkbox" name="products[]" value="'.$value->id.'" '.(in_array($value->id, $existing)?'checked':'').'> '.$value->name.'
                    </label><br/>';
                  }
                ?>
              </div>
            </div>
          </div>
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="phone">Phone <span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="phone" class="form-control col-md-7 col-xs-12" type="text" name="phone" value="<?php echo $principle->phone;?>" required="required">
            </div>
          </div>
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email <span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="email" class="form-control col-md-7 col-xs-12" type="text" name="email" value="<?php echo $principle->email;?>" required="required">
            </div>
          </div>
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="website">Website</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="website" class="form-control col-md-7 col-xs-12" type="text" name="website" value="<?php echo $principle->website;?>">
            </div>
          </div>
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="country">Country</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="country" class="form-control col-md-7 col-xs-12" type="text" name="country" value="<?php echo $principle->country;?>">
            </div>
          </div>
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="address">Address</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <textarea id="country" class="form-control col-md-7 col-xs-12" name="address"><?php echo $principle->address;?></textarea>
            </div>
          </div>
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ref_bd">Reference in BD</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <textarea id="ref_bd" class="form-control col-md-7 col-xs-12" name="ref_bd"><?php echo $principle->ref_bd;?></textarea>
            </div>
          </div>
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ref_global">Reference in Global</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <textarea id="ref_global" class="form-control col-md-7 col-xs-12" name="ref_global"><?php echo $principle->ref_global;?></textarea>
            </div>
          </div>
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="esta_year">Year of Establisment</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="esta_year" class="form-control col-md-7 col-xs-12" type="text" name="esta_year" value="<?php echo $principle->esta_year;?>">
            </div>
          </div>
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pic">Visiting Card
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="file" id="pck" class="form-control col-md-7 col-xs-12" name="visiting_card" accept="image/gif, image/jpeg, image/png">
            </div>
          </div>
          <?php
            if($principle->visiting_card){
              
                echo'<div class="col-xs-12 text-center">
                        <div class="thumbnail" style="max-width:300px;margin:auto;">
                          <div class="image view view-first">
                            <a href="data:image/jpeg;base64,'.base64_encode( $principle->visiting_card ).'" download><img style="width: 100%; display: block;" src="data:image/jpeg;base64,'.base64_encode( $principle->visiting_card ).'" alt="image" /></a>
                          </div>
                          <div class="caption">
                            <div class="checkbox">
                            <label>
                              <input type="checkbox" class="flat" name="delete_current"> Delete Current Image
                            </label>
                          </div>
                          </div>
                        </div>
                </div>';
                echo'<div class="clearfix"></div>';
              
            }
          ?>
          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-6 col-md-offset-3">
              <input id="send" type="submit" class="btn btn-success" name="insert" value="Update Now"/>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
