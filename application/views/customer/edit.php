<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
      <?php if($this->session->userdata('permissions')->customer_list==1):?>  
        <a href="<?=base_url('customer-list')?>" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-th-list"></span> Customer List</a>
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
        <form class="form-horizontal form-label-left" novalidate method="post" action="<?php echo base_url('customer-update');?>" enctype="multipart/form-data">
        	<input type="hidden" name="id" value="<?=$customer->id?>"> 
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Company Name <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="name" class="form-control col-md-7 col-xs-12" required="required" type="text" name="name" value="<?php echo $customer->name;?>">
            </div>
          </div>
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="phone">Phone <span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="phone" class="form-control col-md-7 col-xs-12" value="<?php echo $customer->phone;?>" name="phone" required="required">
            </div>
          </div>
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email <span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="email" id="email" class="form-control col-md-7 col-xs-12" value="<?php echo $customer->email;?>" name="email" required="required">
            </div>
          </div>
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="website">Website Link</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="website" class="form-control col-md-7 col-xs-12" value="<?php echo $customer->website;?>" name="website">
            </div>
          </div>
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="address">Office Address</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <textarea id="address" class="form-control col-md-7 col-xs-12" name="address"><?php echo $customer->address;?></textarea>
            </div>
          </div>
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="address_fac">Factory Address</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <textarea id="address_fac" class="form-control col-md-7 col-xs-12" name="address_fac"><?php echo $customer->address_fac;?></textarea>
            </div>
          </div>
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="type">Customer Type <span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select id="type" class="form-control col-md-7 col-xs-12" name="cust_type" required="required">
              	<option>Select Customer Type</option>
                <?php
                  foreach($customer_type as $k=>$val){
                    echo'<option value="'.$val->id.'" '.($customer->cust_type==$val->id?'selected="selected"':'').'>'.$val->name.'</option>';
                  }
                ?>
              </select>
            </div>
          </div>
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="category">Customer Category <span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select id="category" class="form-control col-md-7 col-xs-12" name="cust_cat" required="required">
              	<option value="">Select Customer Category</option>
              	<option value="1" <?php if($customer->cust_cat==1){echo 'selected';}?>>Verry Important</option>
              	<option value="2" <?php if($customer->cust_cat==2){echo 'selected';}?>>Existing</option>
              	<option value="3" <?php if($customer->cust_cat==3){echo 'selected';}?>>Less Important</option>
              	<option value="4" <?php if($customer->cust_cat==4){echo 'selected';}?>>Prospect</option>
              </select>
            </div>
          </div>
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="lat">Latitude</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input  onclick="showPosition()" type="text" id="lat" class="form-control col-md-7 col-xs-12" value="<?php echo $customer->lat;?>" name="lat">
            </div>
          </div>
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="lon">Longitude</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input onclick="showPosition()" type="text" id="lon" class="form-control col-md-7 col-xs-12" value="<?php echo $customer->lon;?>" name="lon">
            </div>
          </div>
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pic">Visiting Card
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="file" id="pck" class="form-control col-md-7 col-xs-12" name="attachments" accept="image/gif, image/jpeg, image/png">
            </div>
          </div>
          <?php
            if($customer->attachments){
              $cust_file='./public/uploads/customer/'.$customer->attachments;
              if(file_exists($cust_file)){
                echo'<div class="col-xs-12 text-center">
                        <div class="thumbnail" style="max-width:300px;margin:auto;">
                          <div class="image view view-first">
                            <a href="'.base_url().'public/uploads/customer/'.$customer->attachments.'" download><img style="width: 100%; display: block;" src="'.base_url().'public/uploads/customer/'.$customer->attachments.'" alt="image" /></a>
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
            }
          ?>
          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-6 col-md-offset-3">
              <input id="send" type="submit" class="btn btn-success" name="insert" value="Add Now"/>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!--<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCoYSnfjRt1eOxK4OMPPaVVBPAgVp54grs"></script>-->
<script type="text/javascript">
	var options = {
	  enableHighAccuracy: true,
	  timeout: 5000,
	  maximumAge: 0
	};

function success(pos) {
  var crd = pos.coords;
  var lat=crd.latitude;
  var lon=crd.longitude;
  document.getElementById("lat").value=lat;
  document.getElementById("lon").value=lon;
  /*console.log('Your current position is:');
  console.log(`Latitude : ${crd.latitude}`);
  console.log(`Longitude: ${crd.longitude}`);
  console.log(`More or less ${crd.accuracy} meters.`);*/
}

function error(err) {
  console.warn(`ERROR(${err.code}): ${err.message}`);
}
function showPosition(){
	navigator.geolocation.getCurrentPosition(success, error, options);
}
</script>