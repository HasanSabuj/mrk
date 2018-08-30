<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <a class="btn btn-primary btn-xs" href="<?php echo base_url('upcoming-tender');?>"><i class="fa fa-list"></i> List</a>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
          </li>
          <li><a class="close-link"><i class="fa fa-close"></i></a>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <form class="form-horizontal form-label-left" method="post" action="<?php echo base_url('upcoming-tender-save');?>" enctype="multipart/form-data">
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="customer">Customer</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="customer" class="form-control col-md-7 col-xs-12" type="text" name="customer" value="<?php echo set_value('customer');?>">
            </div>
          </div>
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="product">Tender / Product</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="product" class="form-control col-md-7 col-xs-12" type="text" name="product" value="<?php echo set_value('product');?>">
            </div>
          </div>
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="submission_date">Submission Date</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="submission_date" class="form-control col-md-7 col-xs-12" type="text" name="submission_date" value="<?php echo set_value('submission_date');?>">
            </div>
          </div>
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ernest_money">Ernest Money</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="ernest_money" class="form-control col-md-7 col-xs-12" type="text" name="ernest_money" value="<?php echo set_value('ernest_money');?>">
            </div>
          </div>
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="opening_date">Opening Date</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="opening_date" class="form-control col-md-7 col-xs-12" type="text" name="opening_date" value="<?php echo set_value('opening_date');?>">
            </div>
          </div>
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="priority">Priority</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="priority" class="form-control col-md-7 col-xs-12" type="text" name="priority" value="<?php echo set_value('priority');?>">
            </div>
          </div>
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pic">Attachments
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input name="attachments[]" multiple="" class="form-control" accept="image/gif, image/jpeg, image/png, application/pdf, application/vnd.ms-excel" type="file" id="pck">
            </div>
          </div>
          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-6 col-md-offset-3">
              <input id="send" type="submit" class="btn btn-success" name="insert" value="Save"/>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
