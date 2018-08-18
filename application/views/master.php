<?php
	$this->load->view('header');
?>
  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="<?php echo base_url('dashboard');?>" class="site_title"><img src="<?php echo base_url('public/images/min-max-icon.jpg');?>"> <span>MinMax Tech Ltd.</span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
              	<?php
              	if($this->session->userdata('userPic')){
              		if(file_exists('./public/uploads/user/'.$this->session->userdata('userPic'))){
              			$profile_pic=base_url().'public/uploads/user/'.$this->session->userdata('userPic');
              		}else{
              			$profile_pic=base_url().'public/images/img.png';
              		}
              	}else{
              		$profile_pic=base_url().'public/images/img.png';
              	}
              	?>
                <img src="<?=$profile_pic?>" alt="..." class="img-circle profile_img">

              </div>
              <div class="profile_info">
                <span>Welcome,</span>
                <h2><?php echo $this->session->userdata('userName');?></h2>
              </div>
              <div class="clearfix"></div>
            </div>
            <!-- /menu profile quick info -->

            <br />
            <!-- sidebar menu panel -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <!-- sidebar menu -->
              <?php
              	$this->load->view('menu');
              ?>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Logout" href="<?php echo base_url('logout');?>" onclick="return confirm('Want to logout now?')" class="pull-right">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>
            <!-- /menu footer buttons -->
          </div>
          <!-- /sidebar menu panel -->
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <img src="<?=$profile_pic?>" alt=""><?=$this->session->userdata('userName')?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="<?php echo base_url('profile');?>"> Profile</a></li>
                    <li><a href="<?php echo base_url('logout');?>" onclick="return confirm('Want to logout now?')"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                  </ul>
                </li>
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
          	<?php if(isset($page_title)){?>
            <div class="page-title">
              <div class="title_left mt-5 mb-5">
                <h3><?php echo $page_title;?></h3>
              </div>

            </div>
            <?php }?>
            <!-- BEGIN Alert widget-->
		    <?php if($this->session->flashdata('success') || $this->session->flashdata('info') || $this->session->flashdata('error')) { ?>
		    <div class="clearfix"></div>
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
            <div class="clearfix"></div>
            <?php echo validation_errors('<div class="alert alert-error">
		          <button class="close" data-dismiss="alert">×</button>
		          <strong>Error!</strong> ','</div>'); ?>
            <div class="clearfix"></div>
            <?php
              if(isset($main_content)){
              	echo $main_content;
              }else{
                echo'<h2>Sorry but we couldn\'t find this page</h2>';
              }
            ?>

          </div>
        </div>
        <!-- /page content -->

        <!-- footer content -->
        <footer>
          <div class="pull-right">
            MinMax Tech Ltd. &copy; <?php echo date("Y");?> All Rights Reserved. Developed By <a href="http://imaxbd.com" target="_blank">iMaxBD</a>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

    <?php
    	$this->load->view('footer');
    ?>
  </body>
</html>
