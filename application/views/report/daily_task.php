<div class="row">
  <div class="col-xs-12">
    <label>Date Range:</label>
    <form class="form-horizontal" novalidate method="post" action="<?=base_url('daily-update-report-show')?>">
        <div class="control-group">
          <div class="controls">
            <div class="input-prepend input-group">
              <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
              <input type="text" style="width: 200px" name="reservation" id="reservation" class="form-control" value="" required/>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label>User:</label>
          <select name="user" class="form-control" style="max-width: 240px">
            <option value="">Select User</option>
            <?php
              $sql="select id,user_name from users where deleted=? and status=? and id>1";
              $users=$this->db->query($sql,[0,1])->result_array();
              foreach($users as $user){
                echo'<option value="'.$user["id"].'">'.$user["user_name"].'</option>';
              }
            ?>
          </select>
        </div>
      <div><input type="submit" value="Show Report" name="show" class="btn btn-success"></div>
    </form>
  </div>
</div>