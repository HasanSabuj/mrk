<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <?php if($this->session->userdata('permissions')->department_list==1):?>
        <a class="btn btn-primary btn-xs" href="<?php echo base_url('department-list');?>"><i class="fa fa-list"></i> Department List</a>
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
        <form class="form-horizontal form-label-left" method="post" action="<?php echo base_url('department-insert');?>">
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="name" class="form-control col-md-7 col-xs-12" required type="text" name="name" value="<?php echo set_value('name');?>">
            </div>
          </div>
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
