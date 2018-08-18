<?php
  $this->load->view('header');
?>
  <body class="login">
    <!-- BEGIN Alert widget-->
    <?php if($this->session->flashdata('success') || $this->session->flashdata('info') || $this->session->flashdata('error')) { ?>
    <div class="row-fluid">
      <div class="span12">
        <?php if($this->session->flashdata('success')) { ?>
        <div class="alert alert-success">
          <button class="close" data-dismiss="alert">×</button>
          <strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?>
        </div>
        <?php } ?>
        <?php if($this->session->flashdata('info')) { ?>
        <div class="alert alert-info">
          <button class="close" data-dismiss="alert">×</button>
          <strong>Info!</strong> <?php echo $this->session->flashdata('info'); ?>
        </div>
        <?php } ?>
        <?php if($this->session->flashdata('error')) { ?>
        <div class="alert alert-error">
          <button class="close" data-dismiss="alert">×</button>
          <strong>Error!</strong> <?php echo $this->session->flashdata('error'); ?>
        </div>
        <?php } ?>
      </div>
    </div>
    <?php } ?>
    <!-- END Alert widget-->
    <div>
      <div class="login_wrapper">
        <div class="animate form login_form">
          <?php echo validation_errors('<div class="alert alert-error">
              <button class="close" data-dismiss="alert">×</button>
              <strong>Error!</strong> ','</div>'); ?>
          <section class="login_content">
              <?php 
                echo form_open('pass-reset-set');
              ?>
              <input type="hidden" name="id" value="<?=$user->id?>">
              <h1>Reset Password</h1>
              <div>
                <input type="password" class="form-control" placeholder="New Password" required="" autocomplete="off" name="n_pass" />
              </div>
              <div>
                <input type="password" class="form-control" placeholder="Confirm Password" required="" autocomplete="off" name="c_pass" />
              </div>
              <div>
                <button class="btn btn-default" type="submit">Reset Now</button>
              </div>

              <div class="clearfix"></div>

              <div class="separator">

                <div>
                  <h1></i> MinMax Tech Ltd.</h1>
                  <p>&copy; <?php echo date("Y");?> All Rights Reserved. Developed By <a href="http://imaxbd.com" target="_balnk"><b>iMaxBD</b></a></p>
                </div>
              </div>
            <?php echo form_close();?>
          </section>
        </div>
      </div>
    </div>
    <script src="<?php echo base_url();?>vendors/jquery/dist/jquery.min.js"></script>
    <script src="<?php echo base_url();?>vendors/bootstrap/dist/js/bootstrap.min.js"></script>
  </body>
</html>

