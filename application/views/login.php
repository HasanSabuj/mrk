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
                echo form_open('');
              ?>
              <h1>Login</h1>
              <div>
                <input type="email" class="form-control" placeholder="Useremail" required="" autocomplete="off" name="user_email" />
              </div>
              <div>
                <input type="password" class="form-control" placeholder="Password" required="" autocomplete="off" name="password" />
              </div>
              <div>
                <button class="btn btn-default" type="submit">Login</button>
                <a class="reset_pass" href="#" data-target="#lost_password" data-toggle="modal">Lost your password?</a>
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
    <script type="text/javascript">
      $(document).ready(function(){
        $("#send_recovery_mail").click(function(){
          var $result = $("#msg");
          var email =$("#password_recovery_email").val();
          if (validateEmail(email)){
            $.post("<?=base_url('pass-recover')?>",{email:email},function(data){
              var obj=JSON.parse(data);
              $result.text(obj.msg);
              $result.css("color", obj.color);
            })
          }else{
            $result.text(email + " is not valid");
            $result.css("color", "red");
          }
        })
      })

      function validateEmail(email) {
        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
      }

    </script>
    <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true" id="lost_password">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">

          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="myModalLabel2">Recover my password:</h4>
          </div>
          <div class="modal-body">
            <div id="msg"></div>
            <div class="form-group">
              <input type="text" id="password_recovery_email" class="form-control" placeholder="put your email">
            </div>
            <input type="button" value="Recover" id="send_recovery_mail" class="btn btn-primary">
          </div>
        </div>
      </div>
    </div>
  </body>
</html>

