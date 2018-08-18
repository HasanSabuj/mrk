<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <a href="<?=base_url('upcoming-tender-create')?>" class="btn btn-primary btn-xs">Create New</a> 
       
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
          </li>
          <li><a class="close-link"><i class="fa fa-close"></i></a>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        
        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th>Sl No.</th>
              <th>Customer</th>
              <th>Tender / Product</th>
              <th>Submission Date</th>
              <th>Ernest Money</th>
              <th>Opening Date</th>
              <th>Priority</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $i=1;
              foreach($tenders as $k=>$val){
                
                echo'<tr>
		              <td>'.$i.'</td>
		              <td>'.$val->customer.'</td>
		              <td>'.$val->product.'</td>
		              <td>
		              '.$val->submission_date.'
		              </td>
		              <td>
		              '.$val->ernest_money.'
		              </td>
		              <td>
		              '.$val->opening_date.'
		              </td>
		              <td>
		              '.$val->priority.'
		              </td>
		              <td>
                    <a href="'.base_url('upcoming-tender-edit/'.$val->id).'" class="btn btn-success btn-xs" >Edit</a>
		              	<a href="'.base_url('upcoming-tender-remove/'.$val->id).'" class="btn btn-danger btn-xs" onclick="return confirm(\'Are you want to delete it?\')">Delete</a>
		              </td>
		            </tr>';
                $i++;
              }
            ?>
            
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
