<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <a class="btn btn-primary btn-xs" href="<?php echo base_url('product-list');?>"><i class="fa fa-shopping-cart"></i> Product List</a>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
          </li>
          <li><a class="close-link"><i class="fa fa-close"></i></a>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <form class="form-horizontal" method="post" action="<?php echo base_url('product-update');?>" enctype="multipart/form-data">
         <input type="hidden" name="id" value="<?=$product->id?>">
         <div class="form-group">	
          <label for="name">Name <span class="required">*</span>
            </label>
          <input id="name" class="form-control col-xs-12" required type="text" name="name" value="<?php echo $product->name;?>">
        </div>
          <div class="form-group">
          <label for="requirement_form_id">Requirement Form <span class="required">*</span></label>
          <select name="requirement_form_id" id="requirement_form_id" class="form-control col-xs-12" required>
            <option value="">Select one</option>
            <?php
              foreach ($forms as $key => $value) {
                echo'<option value="'.$value->id.'" '.($product->requirement_form_id==$value->id?'selected':'').'>'.$value->name.'</option>';
              }
            ?>
          </select>
        </div>
          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-xs-12">
              <input id="send" type="submit" class="btn btn-success" name="insert" value="Update"/>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
