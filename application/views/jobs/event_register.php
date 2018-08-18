<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <a href="<?=base_url('job-list')?>" class="btn btn-primary btn-xs">Back</a>  
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
          </li>
          <li><a class="close-link"><i class="fa fa-close"></i></a>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <?php
          if($job_details[0]->products){
            $sql="select group_concat(name SEPARATOR '<br> ') as product_name from products where id in(".$job_details[0]->products.")";
            $items=$this->db->query($sql)->row();
            $items=$items->product_name;
          }else{
            $items='';
          }
        ?>
        <table class="table table-bordered">
          <tr>
            <th>JoB No.</th>
            <th>Custom No.</th>
            <th>Product</th>
            <th>Customer</th>
            <th>Prime<br/>Contact</th>
            <th>Created By</th>
            <th>Created At</th>
          </tr>
          <tr>
            <td><?=($job_details[0]->type==1?'T':($job_details[0]->type==2?'CM':'MHD'))?>-<?=$job_details[0]->id?></td>
            <td><?=$job_details[0]->custome_no?></td>
            <td><?=$items?></td>
            <td><?=$job_details[0]->customer_name?></td>
            <td><?=$job_details[0]->contact_name?></td>
            <td><?=$job_details[0]->user_name?></td>
            <td><?=date("d/m/Y",strtotime($job_details[0]->created_at))?></td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</div> 
<div class="row">
  <div class="col-md-3 col-sm-6 col-xs-12">
    <h3>Add New Event</h3>
    <form method="post" action="<?=base_url('job-event-save/'.$job_details[0]->id)?>" enctype="multipart/form-data" id="event_add_form">
      <input type="hidden" value="<?=$job_details[0]->id?>" name="job" id="job_id">
      <div class="form-group">
        <label>Contact Person:</label>
        <select name="contact_id" class="form-control" id="contact_id">
          <option value="">Select Contact Person</option>
          <?php
            foreach ($contacts as $key => $value) {
              echo'<option value="'.$value->id.'">'.$value->name.' ('.$value->designation.')</option>';
            }
          ?>
        </select>
      </div>
      <div class="form-group">
        <label>Event Title * :</label>
        <input type="text" name="event_title" class="form-control" id="event_title">
      </div>
      <div class="form-group">
        <label>Event Details:</label>
        <textarea name="event_details" class="form-control" id="event_details"></textarea>
      </div>
      <div class="form-group">
          <label>Event Date:</label>
          <div class='input-group date' id='myDatepicker1'>
              <input type="text" name="note_date" class="form-control" id="note_date">
              <span class="input-group-addon">
                 <span class="glyphicon glyphicon-calendar"></span>
              </span>
          </div>
      </div>
      <div class="form-group">
          <label>Next Event Date:</label>
          <div class='input-group date' id='myDatepicker2'>
              <input type="text" name="next_date" class="form-control" id="next_date">
              <span class="input-group-addon">
                 <span class="glyphicon glyphicon-calendar"></span>
              </span>
          </div>
      </div>
      <div class="form-group">
          <label>Attachment:</label>
          <div class='input-group date' id='myDatepicker2'>
              <input type="file" name="attachment[]" id="attachment" multiple>
          </div>
      </div>

      <input type="submit" name="save" value="Save" class="btn btn-success pull-right" id="save_job_event">

    </form>
  </div>
  <div class="col-md-9 col-sm-6 col-xs-12">
    <div class="x_panel">
      <div class="x_content">
        <h3>Event History</h3>
        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th>User</th>
                  <th>Contact</th>
                  <th>Event Date</th>
                  <th>Title</th>
                  <th>Description</th>
                  <th>Next date</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  foreach($events as $data){
                    echo'
                      <tr>
                        <td>'.$data->user_name.'<br>@'.date("d-m-Y h:s a",strtotime($data->created_at)).'</td>
                        <td>'.$data->contact_name.'</td>
                        <td>'.$data->note_date.'</td>
                        <td>'.$data->event_title.'</td>
                        <td>'.nl2br($data->event_details).'</td>
                        <td>'.$data->next_date.'</td>
                      </tr>
                    ';
                  }
                ?>
              </tbody>
          </table>
        </div>  
    </div>
  </div>
</div>     