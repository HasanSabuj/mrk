<div class="menu_section">
	<ul class="nav side-menu">
	  <li>
	  	<a href="<?php echo base_url('dashboard');?>"><i class="fa fa-home"></i> Home </a>
	  </li>
	  <!--<li>
	  	<a href="<?php echo base_url('mail-service');?>"><i class="fa fa-envelope"></i> eMail </a>
	  </li>-->
<?php
	if($this->session->userdata('permissions')->job==1){
?>
	  <li>
	  	<a><i class="fa fa-file-text-o"></i> Jobs <span class="fa fa-chevron-down"></span></a>
	  	<ul class="nav child_menu">
	  	<?php if($this->session->userdata('permissions')->job_add==1):?>
          <li><a href="<?php echo base_url('job-create');?>">Create Job / Requirement</a></li>
        <?php endif;?>  

        <?php if($this->session->userdata('permissions')->job_list==1):?>
          <li><a href="<?php echo base_url('job-list');?>">Job List</a></li>
        <?php endif;?>  
        </ul>
	  </li>
<?php
}

if($this->session->userdata('permissions')->drowing_board==1):
	echo'<li>
	  	<a href="'.base_url('design-board').'"><i class="fa fa-file-text-o"></i> Drawing Status </a>
	  </li>';
endif;	
if($this->session->userdata('permissions')->upcoming_tender==1):
	echo'<li>
	  	<a href="'.base_url('upcoming-tender').'"><i class="fa fa-file-text-o"></i> Upcoming Tenders </a>
	  </li>';
endif;	

if($this->session->userdata('permissions')->service==1){

?>
	  <li>
	  	<a><i class="fa fa-file-text-o"></i> Services <span class="fa fa-chevron-down"></span></a>
	  	<ul class="nav child_menu">
	  	<?php if($this->session->userdata('permissions')->service_add==1):?>
          <li><a href="<?php echo base_url('service-create');?>">New Service</a></li>
        <?php endif;?>  

        <?php if($this->session->userdata('permissions')->service_list==1):?>
          <li><a href="<?php echo base_url('service-list');?>">Service List</a></li>
        <?php endif;?>  
        </ul>
	  </li>
<?php
}
if($this->session->userdata('permissions')->report==1){
?>
	  <li>
	  	<a><i class="fa fa-file-text-o"></i> Reports <span class="fa fa-chevron-down"></span></a>
	  	<ul class="nav child_menu">
	  	<?php if($this->session->userdata('permissions')->daily_task_report==1):?>
          <li><a href="<?php echo base_url('daily-update-report');?>">Daily Task Report</a></li>
        <?php endif;?>  
        </ul>
	  </li>
<?php
}
if($this->session->userdata('permissions')->work_plan==1):
?>
	  <li>
	  	<a href="<?php echo base_url('monthly-work-plan');?>"><i class="fa fa-file-text-o"></i> Monthly Work Plan Submit</a>
	  </li>
<?php
endif;
if($this->session->userdata('permissions')->work_plan==1):
?>	  
	  <li>
	  	<a href="<?php echo base_url('daily-work-update');?>"><i class="fa fa-file-text-o"></i> Daily Update Submition</a>
	  </li>
<?php
endif;
if($this->session->userdata('permissions')->customer==1):
?>	  
	  <li>
	  	<a><i class="fa fa-users"></i> Customers <span class="fa fa-chevron-down"></span></a>
	  	<ul class="nav child_menu">
	  	<?php if($this->session->userdata('permissions')->customer_add==1):?>	
          <li><a href="<?php echo base_url('customer-add');?>">Add New Customer</a></li>
        <?php 
        endif;
        if($this->session->userdata('permissions')->customer_list==1):
        ?>  
          <li><a href="<?php echo base_url('customer-list');?>">Customer List</a></li>
        <?php 
        endif;
        ?>  
        </ul>
	  </li>
<?php
endif;
if($this->session->userdata('permissions')->c_type==1):

?>	  
	  <li>
	  	<a><i class="fa fa-list"></i> Customer Type <span class="fa fa-chevron-down"></span></a>
	  	<ul class="nav child_menu">
	  	<?php if($this->session->userdata('permissions')->c_type_add==1):?>	
          <li><a href="<?php echo base_url('customer-type-add');?>">Add New Customer Type</a></li>
        <?php endif;?>
        <?php if($this->session->userdata('permissions')->c_type_list==1):?>  
          <li><a href="<?php echo base_url('customer-type-list');?>">Customer Type List</a></li>
        <?php endif;?>  
        </ul>
	  </li>
<?php 
endif;
if($this->session->userdata('permissions')->principle==1):
?>	  
	  <li>
	  	<a><i class="fa fa-list"></i> Principles <span class="fa fa-chevron-down"></span></a>
	  	<ul class="nav child_menu">
	  	<?php if($this->session->userdata('permissions')->principle_add==1):?>	
          <li><a href="<?php echo base_url('principle-add');?>">Add New Principle</a></li>
        <?php endif;?>
        <?php if($this->session->userdata('permissions')->principle_list==1):?>  
          <li><a href="<?php echo base_url('principle-list');?>">Principle List</a></li>
        <?php endif;?>  
        </ul>
	  </li>
<?php
endif;
if($this->session->userdata('permissions')->product==1):
?>	  
	  <li>
	  	<a><i class="fa fa-shopping-cart"></i> Products <span class="fa fa-chevron-down"></span></a>
	  	<ul class="nav child_menu">
	  	<?php if($this->session->userdata('permissions')->product_add==1):?>	
          <li><a href="<?php echo base_url('product-add');?>">Add New Product</a></li>
        <?php 
        endif;
        if($this->session->userdata('permissions')->product_list==1):
        ?>  
          <li><a href="<?php echo base_url('product-list');?>">Product List</a></li>
        <?php 
        endif;
        if($this->session->userdata('permissions')->form_add==1):
        ?>  
          <li><a href="<?php echo base_url('form-add');?>">Create New Form</a></li>
        <?php
        endif;
        if($this->session->userdata('permissions')->form_list==1):
        ?>  
          <li><a href="<?php echo base_url('form-list');?>">Requirement Form List</a></li>
        <?php 
        endif;
        ?>  
        </ul>
	  </li>
<?php 
endif;
if($this->session->userdata('permissions')->settings==1):
?>	  
		<li><a><i class="fa fa-cogs"></i> Settings <span class="fa fa-chevron-down"></span></a>
			<ul class="nav child_menu">
				<?php if($this->session->userdata('permissions')->department==1):?>
			    <li><a>Department<span class="fa fa-chevron-down"></span></a>
			      <ul class="nav child_menu">
			    <?php if($this->session->userdata('permissions')->department_add==1):?>
			        <li class="sub_menu"><a href="<?=base_url('department-add')?>">Add New</a>
			        </li>
			    <?php
			    endif;
			    if($this->session->userdata('permissions')->department_list==1):
			    ?>
			        <li><a href="<?=base_url('department-list')?>">Department List</a>
			        </li>
			    <?php
			    endif;
			    ?>    
			      </ul>
			    </li>
			<?php
			 endif;
			 if($this->session->userdata('permissions')->designation==1):
			?>
			    <li><a>Designation<span class="fa fa-chevron-down"></span></a>
			      <ul class="nav child_menu">
			    <?php if($this->session->userdata('permissions')->designation_add==1):?>
			        <li class="sub_menu"><a href="<?=base_url('designation-add')?>">Add New</a>
			        </li>
			    <?php endif;?>
			    <?php if($this->session->userdata('permissions')->designation_list==1):?>
			        <li><a href="<?=base_url('designation-list')?>">Designation List</a>
			        </li>
			    <?php endif;?>    
			      </ul>
			    </li>
			<?php
			endif;
			if($this->session->userdata('permissions')->user==1):
			?>    
			    <li><a>User<span class="fa fa-chevron-down"></span></a>
			      <ul class="nav child_menu">
			      	<?php if($this->session->userdata('permissions')->user_add==1):?>
			        <li class="sub_menu"><a href="<?=base_url('user-add')?>">Add New</a>
			        </li>
			    <?php endif;?>
			    <?php if($this->session->userdata('permissions')->user_list==1):?>
			        <li><a href="<?=base_url('user-list')?>">User List</a>
			        </li>
			    <?php endif;?>    
			      </ul>
			    </li>
			<?php 
			endif;
			?>    
			</ul>
		</li>
<?php endif;?>		
	</ul>
</div>

</div>