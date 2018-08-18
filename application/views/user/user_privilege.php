<div class="row">	
	<form method="post" action="<?=base_url('privilege-update')?>">
		<input type="hidden" value="<?=$permission->id?>" name="id">
		<input type="hidden" value="<?=$permission->user_id?>" name="user_id">
		
		<table>
			<tr>
				<td colspan="8" style="text-align: center;">
					<div class="switch-field" style="width: 145px;margin: auto;">
				      <div class="switch-title"><b>Check All:</b></div>
				      <input type="radio" id="check_all_left" name="check_all" value="1"/>
				      <label for="check_all_left">Yes</label>
				      <input type="radio" id="check_all_right" name="check_all" value="0"/>
				      <label for="check_all_right">No</label>
				    </div>
				</td>
			</tr>

			<tr class="bg-info">
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Job menu?</b></div>
				      <input type="radio" id="job_left" name="job" value="1" <?=($permission->job==1?'checked':'')?>/>
				      <label for="job_left">Yes</label>
				      <input type="radio" id="job_right" name="job" value="0" <?=($permission->job==0?'checked':'')?>/>
				      <label for="job_right">No</label>
				    </div>
				</td>
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Job add?</b></div>
				      <input type="radio" id="job_add_left" name="job_add" value="1" <?=($permission->job_add==1?'checked':'')?>/>
				      <label for="job_add_left">Yes</label>
				      <input type="radio" id="job_add_right" name="job_add" value="0" <?=($permission->job_add==0?'checked':'')?>/>
				      <label for="job_add_right">No</label>
				    </div>
				</td>
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Job edit?</b></div>
				      <input type="radio" id="job_edit_left" name="job_edit" value="1" <?=($permission->job_edit==1?'checked':'')?>/>
				      <label for="job_edit_left">Yes</label>
				      <input type="radio" id="job_edit_right" name="job_edit" value="0" <?=($permission->job_edit==0?'checked':'')?>/>
				      <label for="job_edit_right">No</label>
				    </div>
				</td>
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Job delete?</b></div>
				      <input type="radio" id="job_delete_left" name="job_delete" value="1" <?=($permission->job_delete==1?'checked':'')?>/>
				      <label for="job_delete_left">Yes</label>
				      <input type="radio" id="job_delete_right" name="job_delete" value="0" <?=($permission->job_delete==0?'checked':'')?>/>
				      <label for="job_delete_right">No</label>
				    </div>
				</td>
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Job list?</b></div>
				      <input type="radio" id="job_list_left" name="job_list" value="1" <?=($permission->job_list==1?'checked':'')?>/>
				      <label for="job_list_left">Yes</label>
				      <input type="radio" id="job_list_right" name="job_list" value="0" <?=($permission->job_list==0?'checked':'')?>/>
				      <label for="job_list_right">No</label>
				    </div>
				</td>
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Job trash list?</b></div>
				      <input type="radio" id="job_trash_left" name="job_trash" value="1" <?=($permission->job_trash==1?'checked':'')?>/>
				      <label for="job_trash_left">Yes</label>
				      <input type="radio" id="job_trash_right" name="job_trash" value="0" <?=($permission->job_trash==0?'checked':'')?>/>
				      <label for="job_trash_right">No</label>
				    </div>
				</td>
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Job trash to move?</b></div>
				      <input type="radio" id="job_move_left" name="job_move" value="1" <?=($permission->job_move==1?'checked':'')?>/>
				      <label for="job_move_left">Yes</label>
				      <input type="radio" id="job_move_right" name="job_move" value="0" <?=($permission->job_move==0?'checked':'')?>/>
				      <label for="job_move_right">No</label>
				    </div>
				</td>
				<td style="vertical-align: bottom;">
					<div style="padding: 5px">
						<input type="submit" name="submit1" value="Save" class="btn btn-success">
					</div>
				</td>
			</tr>
			<tr class="bg-warning">
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Job Handle Setup?</b></div>
				      <input type="radio" id="job_handle_left" name="job_handle" value="1" <?=($permission->job_handle==1?'checked':'')?>/>
				      <label for="job_handle_left">Yes</label>
				      <input type="radio" id="job_handle_right" name="job_handle" value="0" <?=($permission->job_handle==0?'checked':'')?>/>
				      <label for="job_handle_right">No</label>
				    </div>
				</td>
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Job Close?</b></div>
				      <input type="radio" id="job_close_left" name="job_close" value="1" <?=($permission->job_close==1?'checked':'')?>/>
				      <label for="job_close_left">Yes</label>
				      <input type="radio" id="job_close_right" name="job_close" value="0" <?=($permission->job_close==0?'checked':'')?>/>
				      <label for="job_close_right">No</label>
				    </div>
				</td>
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Closed Job List?</b></div>
				      <input type="radio" id="job_close_list_left" name="job_close_list" value="1" <?=($permission->job_close_list==1?'checked':'')?>/>
				      <label for="job_close_list_left">Yes</label>
				      <input type="radio" id="job_close_list_right" name="job_close_list" value="0" <?=($permission->job_close_list==0?'checked':'')?>/>
				      <label for="job_close_list_right">No</label>
				    </div>
				</td>
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Closed Job Move?</b></div>
				      <input type="radio" id="job_close_move_left" name="job_close_move" value="1" <?=($permission->job_close_move==1?'checked':'')?>/>
				      <label for="job_close_move_left">Yes</label>
				      <input type="radio" id="job_close_move_right" name="job_close_move" value="0" <?=($permission->job_close_move==0?'checked':'')?>/>
				      <label for="job_close_move_right">No</label>
				    </div>
				</td>
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Drawing Board?</b></div>
				      <input type="radio" id="drowing_board_left" name="drowing_board" value="1" <?=($permission->drowing_board==1?'checked':'')?>/>
				      <label for="drowing_board_left">Yes</label>
				      <input type="radio" id="drowing_board_right" name="drowing_board" value="0" <?=($permission->drowing_board==0?'checked':'')?>/>
				      <label for="drowing_board_right">No</label>
				    </div>
				</td>
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Upcoming Tender?</b></div>
				      <input type="radio" id="upcoming_tender_left" name="upcoming_tender" value="1" <?=($permission->upcoming_tender==1?'checked':'')?>/>
				      <label for="upcoming_tender_left">Yes</label>
				      <input type="radio" id="upcoming_tender_right" name="upcoming_tender" value="0" <?=($permission->upcoming_tender==0?'checked':'')?>/>
				      <label for="upcoming_tender_right">No</label>
				    </div>
				</td>
			</tr>
			<tr class="bg-info">
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Service menu?</b></div>
				      <input type="radio" id="service_left" name="service" value="1" <?=($permission->service==1?'checked':'')?>/>
				      <label for="service_left">Yes</label>
				      <input type="radio" id="service_right" name="service" value="0" <?=($permission->service==0?'checked':'')?>/>
				      <label for="service_right">No</label>
				    </div>
				</td>
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Service add?</b></div>
				      <input type="radio" id="service_add_left" name="service_add" value="1" <?=($permission->service_add==1?'checked':'')?>/>
				      <label for="service_add_left">Yes</label>
				      <input type="radio" id="service_add_right" name="service_add" value="0" <?=($permission->service_add==0?'checked':'')?>/>
				      <label for="service_add_right">No</label>
				    </div>
				</td>
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Service edit?</b></div>
				      <input type="radio" id="service_edit_left" name="service_edit" value="1" <?=($permission->service_edit==1?'checked':'')?>/>
				      <label for="service_edit_left">Yes</label>
				      <input type="radio" id="service_edit_right" name="service_edit" value="0" <?=($permission->service_edit==0?'checked':'')?>/>
				      <label for="service_edit_right">No</label>
				    </div>
				</td>
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Service delete?</b></div>
				      <input type="radio" id="service_delete_left" name="service_delete" value="1" <?=($permission->service_delete==1?'checked':'')?>/>
				      <label for="service_delete_left">Yes</label>
				      <input type="radio" id="service_delete_right" name="service_delete" value="0" <?=($permission->service_delete==0?'checked':'')?>/>
				      <label for="service_delete_right">No</label>
				    </div>
				</td>
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Service list?</b></div>
				      <input type="radio" id="service_list_left" name="service_list" value="1" <?=($permission->service_list==1?'checked':'')?>/>
				      <label for="service_list_left">Yes</label>
				      <input type="radio" id="service_list_right" name="service_list" value="0" <?=($permission->service_list==0?'checked':'')?>/>
				      <label for="service_list_right">No</label>
				    </div>
				</td>
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Service trash list?</b></div>
				      <input type="radio" id="service_trash_list_left" name="service_trash_list" value="1" <?=($permission->service_trash_list==1?'checked':'')?>/>
				      <label for="service_trash_list_left">Yes</label>
				      <input type="radio" id="service_trash_list_right" name="service_trash_list" value="0" <?=($permission->service_trash_list==0?'checked':'')?>/>
				      <label for="service_trash_list_right">No</label>
				    </div>
				</td>
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Service trash to move?</b></div>
				      <input type="radio" id="service_move_left" name="service_move" value="1" <?=($permission->service_move==1?'checked':'')?>/>
				      <label for="service_move_left">Yes</label>
				      <input type="radio" id="service_move_right" name="service_move" value="0" <?=($permission->service_move==0?'checked':'')?>/>
				      <label for="service_move_right">No</label>
				    </div>
				</td>
				<td style="vertical-align: bottom;">
					<div style="padding: 5px">
						<input type="submit" name="submitx1" value="Save" class="btn btn-success">
					</div>
				</td>
			</tr>
			<tr class="bg-warning">
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Service Handle Setup?</b></div>
				      <input type="radio" id="service_handler_left" name="service_handler" value="1" <?=($permission->job_handle==1?'checked':'')?>/>
				      <label for="service_handler_left">Yes</label>
				      <input type="radio" id="service_handler_right" name="service_handler" value="0" <?=($permission->service_handler==0?'checked':'')?>/>
				      <label for="service_handler_right">No</label>
				    </div>
				</td>
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Service Close?</b></div>
				      <input type="radio" id="service_close_left" name="service_close" value="1" <?=($permission->service_close==1?'checked':'')?>/>
				      <label for="job_close_left">Yes</label>
				      <input type="radio" id="service_close_right" name="service_close" value="0" <?=($permission->service_close==0?'checked':'')?>/>
				      <label for="service_close_right">No</label>
				    </div>
				</td>
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Closed Service List?</b></div>
				      <input type="radio" id="service_close_list_left" name="service_close_list" value="1" <?=($permission->service_close_list==1?'checked':'')?>/>
				      <label for="service_close_list_left">Yes</label>
				      <input type="radio" id="service_close_list_right" name="service_close_list" value="0" <?=($permission->service_close_list==0?'checked':'')?>/>
				      <label for="service_close_list_right">No</label>
				    </div>
				</td>
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Closed Service Move?</b></div>
				      <input type="radio" id="service_close_move_left" name="service_close_move" value="1" <?=($permission->service_close_move==1?'checked':'')?>/>
				      <label for="service_close_move_left">Yes</label>
				      <input type="radio" id="service_close_move_right" name="service_close_move" value="0" <?=($permission->service_close_move==0?'checked':'')?>/>
				      <label for="service_close_move_right">No</label>
				    </div>
				</td>
			</tr>	
			<tr class="bg-info">
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Monthly work plan?</b></div>
				      <input type="radio" id="work_plan_left" name="work_plan" value="1" <?=($permission->work_plan==1?'checked':'')?>/>
				      <label for="work_plan_left">Yes</label>
				      <input type="radio" id="work_plan_right" name="work_plan" value="0" <?=($permission->work_plan==0?'checked':'')?>/>
				      <label for="work_plan_right">No</label>
				    </div>
				</td>
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Daily update?</b></div>
				      <input type="radio" id="daily_update_left" name="daily_update" value="1" <?=($permission->daily_update==1?'checked':'')?>/>
				      <label for="daily_update_left">Yes</label>
				      <input type="radio" id="daily_update_right" name="daily_update" value="0" <?=($permission->daily_update==0?'checked':'')?>/>
				      <label for="daily_update_right">No</label>
				    </div>
				</td>
				<td colspan="6">
					<div class="switch-field">
				      <div class="switch-title"><b>Aditional task?</b></div>
				      <input type="radio" id="aditional_task_left" name="aditional_task" value="1" <?=($permission->aditional_task==1?'checked':'')?>/>
				      <label for="aditional_task_left">Yes</label>
				      <input type="radio" id="aditional_task_right" name="aditional_task" value="0" <?=($permission->aditional_task==0?'checked':'')?>/>
				      <label for="aditional_task_right">No</label>
				    </div>
				</td>
			</tr>
			<tr class="bg-warning">
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Customer menu?</b></div>
				      <input type="radio" id="customer_left" name="customer" value="1" <?=($permission->customer==1?'checked':'')?>/>
				      <label for="customer_left">Yes</label>
				      <input type="radio" id="customer_right" name="customer" value="0" <?=($permission->customer==0?'checked':'')?>/>
				      <label for="customer_right">No</label>
				    </div>
				</td>
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Customer add?</b></div>
				      <input type="radio" id="customer_add_left" name="customer_add" value="1" <?=($permission->customer_add==1?'checked':'')?>/>
				      <label for="customer_add_left">Yes</label>
				      <input type="radio" id="customer_add_right" name="customer_add" value="0" <?=($permission->customer_add==0?'checked':'')?>/>
				      <label for="customer_add_right">No</label>
				    </div>
				</td>
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Customer edit?</b></div>
				      <input type="radio" id="customer_edit_left" name="customer_edit" value="1" <?=($permission->customer_edit==1?'checked':'')?>/>
				      <label for="customer_edit_left">Yes</label>
				      <input type="radio" id="customer_edit_right" name="customer_edit" value="0" <?=($permission->customer_edit==0?'checked':'')?>/>
				      <label for="customer_edit_right">No</label>
				    </div>
				</td>
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Customer delete?</b></div>
				      <input type="radio" id="customer_delete_left" name="customer_delete" value="1" <?=($permission->customer_delete==1?'checked':'')?>/>
				      <label for="customer_delete_left">Yes</label>
				      <input type="radio" id="customer_delete_right" name="customer_delete" value="0" <?=($permission->customer_delete==0?'checked':'')?>/>
				      <label for="customer_delete_right">No</label>
				    </div>
				</td>
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Customer list?</b></div>
				      <input type="radio" id="customer_list_left" name="customer_list" value="1" <?=($permission->customer_list==1?'checked':'')?>/>
				      <label for="customer_list_left">Yes</label>
				      <input type="radio" id="customer_list_right" name="customer_list" value="0" <?=($permission->customer_list==0?'checked':'')?>/>
				      <label for="customer_list_right">No</label>
				    </div>
				</td>
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Customer trash list?</b></div>
				      <input type="radio" id="customer_trash_left" name="customer_trash" value="1" <?=($permission->customer_trash==1?'checked':'')?>/>
				      <label for="customer_trash_left">Yes</label>
				      <input type="radio" id="customer_trash_right" name="customer_trash" value="0" <?=($permission->customer_trash==0?'checked':'')?>/>
				      <label for="customer_trash_right">No</label>
				    </div>
				</td>
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Customer trash to move?</b></div>
				      <input type="radio" id="customer_move_left" name="customer_move" value="1" <?=($permission->customer_move==1?'checked':'')?>/>
				      <label for="customer_move_left">Yes</label>
				      <input type="radio" id="customer_move_right" name="customer_move" value="0" <?=($permission->customer_move==0?'checked':'')?>/>
				      <label for="customer_move_right">No</label>
				    </div>
				</td>
				<td style="vertical-align: bottom;">
					<div style="padding: 5px">
						<input type="submit" name="submit2" value="Save" class="btn btn-success">
					</div>
				</td>
			</tr>
			<tr class="bg-info">
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Customer contact add?</b></div>
				      <input type="radio" id="c_contact_add_left" name="c_contact_add" value="1" <?=($permission->c_contact_add==1?'checked':'')?>/>
				      <label for="c_contact_add_left">Yes</label>
				      <input type="radio" id="c_contact_add_right" name="c_contact_add" value="0" <?=($permission->c_contact_add==0?'checked':'')?>/>
				      <label for="c_contact_add_right">No</label>
				    </div>
				</td>
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Customer contact edit?</b></div>
				      <input type="radio" id="c_contact_edit_left" name="c_contact_edit" value="1" <?=($permission->c_contact_edit==1?'checked':'')?>/>
				      <label for="c_contact_edit_left">Yes</label>
				      <input type="radio" id="c_contact_edit_right" name="c_contact_edit" value="0" <?=($permission->c_contact_edit==0?'checked':'')?>/>
				      <label for="c_contact_edit_right">No</label>
				    </div>
				</td>
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Customer contact delete?</b></div>
				      <input type="radio" id="c_contact_delete_left" name="c_contact_delete" value="1" <?=($permission->c_contact_delete==1?'checked':'')?>/>
				      <label for="c_contact_delete_left">Yes</label>
				      <input type="radio" id="c_contact_delete_right" name="c_contact_delete" value="0" <?=($permission->c_contact_delete==0?'checked':'')?>/>
				      <label for="c_contact_delete_right">No</label>
				    </div>
				</td>
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Customer contact list?</b></div>
				      <input type="radio" id="c_contact_list_left" name="c_contact_list" value="1" <?=($permission->c_contact_list==1?'checked':'')?>/>
				      <label for="c_contact_list_left">Yes</label>
				      <input type="radio" id="c_contact_list_right" name="c_contact_list" value="0" <?=($permission->c_contact_list==0?'checked':'')?>/>
				      <label for="c_contact_list_right">No</label>
				    </div>
				</td>
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Customer contact trash list?</b></div>
				      <input type="radio" id="c_contact_trash_left" name="c_contact_trash" value="1" <?=($permission->c_contact_trash==1?'checked':'')?>/>
				      <label for="c_contact_trash_left">Yes</label>
				      <input type="radio" id="c_contact_trash_right" name="c_contact_trash" value="0" <?=($permission->c_contact_trash==0?'checked':'')?>/>
				      <label for="c_contact_trash_right">No</label>
				    </div>
				</td>
				<td colspan="3">
					<div class="switch-field">
				      <div class="switch-title"><b>Customer contact<br/>trash to move?</b></div>
				      <input type="radio" id="c_contact_move_left" name="c_contact_move" value="1" <?=($permission->c_contact_move==1?'checked':'')?>/>
				      <label for="c_contact_move_left">Yes</label>
				      <input type="radio" id="c_contact_move_right" name="c_contact_move" value="0" <?=($permission->c_contact_move==0?'checked':'')?>/>
				      <label for="c_contact_move_right">No</label>
				    </div>
				</td>
			</tr>
			<tr class="bg-warning">
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Customer type menu?</b></div>
				      <input type="radio" id="c_type_left" name="c_type" value="1" <?=($permission->c_type==1?'checked':'')?>/>
				      <label for="c_type_left">Yes</label>
				      <input type="radio" id="c_type_right" name="c_type" value="0" <?=($permission->c_type==0?'checked':'')?>/>
				      <label for="c_type_right">No</label>
				    </div>
				</td>
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Customer type add?</b></div>
				      <input type="radio" id="c_type_add_left" name="c_type_add" value="1" <?=($permission->c_type_add==1?'checked':'')?>/>
				      <label for="c_type_add_left">Yes</label>
				      <input type="radio" id="c_type_add_right" name="c_type_add" value="0" <?=($permission->c_type_add==0?'checked':'')?>/>
				      <label for="c_type_add_right">No</label>
				    </div>
				</td>
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Customer type edit?</b></div>
				      <input type="radio" id="c_type_edit_left" name="c_type_edit" value="1" <?=($permission->c_type_edit==1?'checked':'')?>/>
				      <label for="c_type_edit_left">Yes</label>
				      <input type="radio" id="c_type_edit_right" name="c_type_edit" value="0" <?=($permission->c_type_edit==0?'checked':'')?>/>
				      <label for="c_type_edit_right">No</label>
				    </div>
				</td>
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Customer type delete?</b></div>
				      <input type="radio" id="c_type_delete_left" name="c_type_delete" value="1" <?=($permission->c_type_delete==1?'checked':'')?>/>
				      <label for="c_type_delete_left">Yes</label>
				      <input type="radio" id="c_type_delete_right" name="c_type_delete" value="0" <?=($permission->c_type_delete==0?'checked':'')?>/>
				      <label for="c_type_delete_right">No</label>
				    </div>
				</td>
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Customer type list?</b></div>
				      <input type="radio" id="c_type_list_left" name="c_type_list" value="1" <?=($permission->c_type_list==1?'checked':'')?>/>
				      <label for="c_type_list_left">Yes</label>
				      <input type="radio" id="c_type_list_right" name="c_type_list" value="0" <?=($permission->c_type_list==0?'checked':'')?>/>
				      <label for="c_type_list_right">No</label>
				    </div>
				</td>
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Customer type trash list?</b></div>
				      <input type="radio" id="c_type_trash_left" name="c_type_trash" value="1" <?=($permission->c_type_trash==1?'checked':'')?>/>
				      <label for="c_type_trash_left">Yes</label>
				      <input type="radio" id="c_type_trash_right" name="c_type_trash" value="0" <?=($permission->c_type_trash==0?'checked':'')?>/>
				      <label for="c_type_trash_right">No</label>
				    </div>
				</td>
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Customer type trash to move?</b></div>
				      <input type="radio" id="c_type_move_left" name="c_type_move" value="1" <?=($permission->c_type_move==1?'checked':'')?>/>
				      <label for="c_type_move_left">Yes</label>
				      <input type="radio" id="c_type_move_right" name="c_type_move" value="0" <?=($permission->c_type_move==0?'checked':'')?>/>
				      <label for="c_type_move_right">No</label>
				    </div>
				</td>
				<td style="vertical-align: bottom;">
					<div style="padding: 5px">
						<input type="submit" name="submit3" value="Save" class="btn btn-success">
					</div>
				</td>
			</tr>
			<tr class="bg-info">
				<td colspan="8">
					<div class="switch-field">
				      <div class="switch-title"><b>Settings menu?</b></div>
				      <input type="radio" id="settings_left" name="settings" value="1" <?=($permission->settings==1?'checked':'')?>/>
				      <label for="settings_left">Yes</label>
				      <input type="radio" id="settings_right" name="settings" value="0" <?=($permission->settings==0?'checked':'')?>/>
				      <label for="settings_right">No</label>
				    </div>
				</td>
			</tr>
			<tr class="bg-warning">
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Principle menu?</b></div>
				      <input type="radio" id="principle_left" name="principle" value="1" <?=($permission->principle==1?'checked':'')?>/>
				      <label for="principle_left">Yes</label>
				      <input type="radio" id="principle_right" name="principle" value="0" <?=($permission->principle==0?'checked':'')?>/>
				      <label for="principle_right">No</label>
				    </div>
				</td>
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Principle add?</b></div>
				      <input type="radio" id="principle_add_left" name="principle_add" value="1" <?=($permission->principle_add==1?'checked':'')?>/>
				      <label for="principle_add_left">Yes</label>
				      <input type="radio" id="principle_add_right" name="principle_add" value="0" <?=($permission->principle_add==0?'checked':'')?>/>
				      <label for="principle_add_right">No</label>
				    </div>
				</td>
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Principle edit?</b></div>
				      <input type="radio" id="principle_edit_left" name="principle_edit" value="1" <?=($permission->principle_edit==1?'checked':'')?>/>
				      <label for="principle_edit_left">Yes</label>
				      <input type="radio" id="principle_edit_right" name="principle_edit" value="0" <?=($permission->principle_edit==0?'checked':'')?>/>
				      <label for="principle_edit_right">No</label>
				    </div>
				</td>
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Principle delete?</b></div>
				      <input type="radio" id="principle_delete_left" name="principle_delete" value="1" <?=($permission->principle_delete==1?'checked':'')?>/>
				      <label for="principle_delete_left">Yes</label>
				      <input type="radio" id="principle_delete_right" name="principle_delete" value="0" <?=($permission->principle_delete==0?'checked':'')?>/>
				      <label for="principle_delete_right">No</label>
				    </div>
				</td>
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Principle list?</b></div>
				      <input type="radio" id="principle_list_left" name="principle_list" value="1" <?=($permission->principle_list==1?'checked':'')?>/>
				      <label for="principle_list_left">Yes</label>
				      <input type="radio" id="principle_list_right" name="principle_list" value="0" <?=($permission->principle_list==0?'checked':'')?>/>
				      <label for="principle_list_right">No</label>
				    </div>
				</td>
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Principle trash list?</b></div>
				      <input type="radio" id="principle_trash_left" name="principle_trash" value="1" <?=($permission->principle_trash==1?'checked':'')?>/>
				      <label for="principle_trash_left">Yes</label>
				      <input type="radio" id="principle_trash_right" name="principle_trash" value="0" <?=($permission->principle_trash==0?'checked':'')?>/>
				      <label for="principle_trash_right">No</label>
				    </div>
				</td>
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Principle trash to move?</b></div>
				      <input type="radio" id="principle_move_left" name="principle_move" value="1" <?=($permission->principle_move==1?'checked':'')?>/>
				      <label for="principle_move_left">Yes</label>
				      <input type="radio" id="principle_move_right" name="principle_move" value="0" <?=($permission->principle_move==0?'checked':'')?>/>
				      <label for="principle_move_right">No</label>
				    </div>
				</td>
				<td style="vertical-align: bottom;">
					<div style="padding: 5px">
						<input type="submit" name="submit4" value="Save" class="btn btn-success">
					</div>
				</td>
			</tr>
			<tr class="bg-info">
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Principle contact add?</b></div>
				      <input type="radio" id="p_contact_add_left" name="p_contact_add" value="1" <?=($permission->p_contact_add==1?'checked':'')?>/>
				      <label for="p_contact_add_left">Yes</label>
				      <input type="radio" id="p_contact_add_right" name="p_contact_add" value="0" <?=($permission->p_contact_add==0?'checked':'')?>/>
				      <label for="p_contact_add_right">No</label>
				    </div>
				</td>
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Contact edit?</b></div>
				      <input type="radio" id="p_contact_edit_left" name="p_contact_edit" value="1" <?=($permission->p_contact_edit==1?'checked':'')?>/>
				      <label for="p_contact_edit_left">Yes</label>
				      <input type="radio" id="p_contact_edit_right" name="p_contact_edit" value="0" <?=($permission->p_contact_edit==0?'checked':'')?>/>
				      <label for="p_contact_edit_right">No</label>
				    </div>
				</td>
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Contact delete?</b></div>
				      <input type="radio" id="p_contact_delete_left" name="p_contact_delete" value="1" <?=($permission->p_contact_delete==1?'checked':'')?>/>
				      <label for="p_contact_delete_left">Yes</label>
				      <input type="radio" id="p_contact_delete_right" name="p_contact_delete" value="0" <?=($permission->p_contact_delete==0?'checked':'')?>/>
				      <label for="p_contact_delete_right">No</label>
				    </div>
				</td>
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Contact list?</b></div>
				      <input type="radio" id="p_contact_list_left" name="p_contact_list" value="1" <?=($permission->p_contact_list==1?'checked':'')?>/>
				      <label for="p_contact_list_left">Yes</label>
				      <input type="radio" id="p_contact_list_right" name="p_contact_list" value="0" <?=($permission->p_contact_list==0?'checked':'')?>/>
				      <label for="p_contact_list_right">No</label>
				    </div>
				</td>
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Contact trash list?</b></div>
				      <input type="radio" id="p_contact_trash_left" name="p_contact_trash" value="1" <?=($permission->p_contact_trash==1?'checked':'')?>/>
				      <label for="p_contact_trash_left">Yes</label>
				      <input type="radio" id="p_contact_trash_right" name="p_contact_trash" value="0" <?=($permission->p_contact_trash==0?'checked':'')?>/>
				      <label for="p_contact_trash_right">No</label>
				    </div>
				</td>
				<td colspan="3">
					<div class="switch-field">
				      <div class="switch-title"><b>Contact trash to move?</b></div>
				      <input type="radio" id="p_contact_move_left" name="p_contact_move" value="1" <?=($permission->p_contact_move==1?'checked':'')?>/>
				      <label for="p_contact_move_left">Yes</label>
				      <input type="radio" id="p_contact_move_right" name="p_contact_move" value="0" <?=($permission->p_contact_move==0?'checked':'')?>/>
				      <label for="p_contact_move_right">No</label>
				    </div>
				</td>
			</tr>
			<tr class="bg-warning">
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Product menu?</b></div>
				      <input type="radio" id="product_left" name="product" value="1" <?=($permission->product==1?'checked':'')?>/>
				      <label for="product_left">Yes</label>
				      <input type="radio" id="product_right" name="product" value="0" <?=($permission->product==0?'checked':'')?>/>
				      <label for="product_right">No</label>
				    </div>
				</td>
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Product add?</b></div>
				      <input type="radio" id="product_add_left" name="product_add" value="1" <?=($permission->product_add==1?'checked':'')?>/>
				      <label for="product_add_left">Yes</label>
				      <input type="radio" id="product_add_right" name="product_add" value="0" <?=($permission->product_add==0?'checked':'')?>/>
				      <label for="product_add_right">No</label>
				    </div>
				</td>
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Product edit?</b></div>
				      <input type="radio" id="product_edit_left" name="product_edit" value="1" <?=($permission->product_edit==1?'checked':'')?>/>
				      <label for="product_edit_left">Yes</label>
				      <input type="radio" id="product_edit_right" name="product_edit" value="0" <?=($permission->product_edit==0?'checked':'')?>/>
				      <label for="product_edit_right">No</label>
				    </div>
				</td>
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Product delete?</b></div>
				      <input type="radio" id="product_delete_left" name="product_delete" value="1" <?=($permission->product_delete==1?'checked':'')?>/>
				      <label for="product_delete_left">Yes</label>
				      <input type="radio" id="product_delete_right" name="product_delete" value="0" <?=($permission->product_delete==0?'checked':'')?>/>
				      <label for="product_delete_right">No</label>
				    </div>
				</td>
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Product list?</b></div>
				      <input type="radio" id="product_list_left" name="product_list" value="1" <?=($permission->product_list==1?'checked':'')?>/>
				      <label for="product_list_left">Yes</label>
				      <input type="radio" id="product_list_right" name="product_list" value="0" <?=($permission->product_list==0?'checked':'')?>/>
				      <label for="product_list_right">No</label>
				    </div>
				</td>
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Product trash list?</b></div>
				      <input type="radio" id="product_trash_left" name="product_trash" value="1" <?=($permission->product_trash==1?'checked':'')?>/>
				      <label for="product_trash_left">Yes</label>
				      <input type="radio" id="product_trash_right" name="product_trash" value="0" <?=($permission->product_trash==0?'checked':'')?>/>
				      <label for="product_trash_right">No</label>
				    </div>
				</td>
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Product trash to move?</b></div>
				      <input type="radio" id="product_move_left" name="product_move" value="1" <?=($permission->product_move==1?'checked':'')?>/>
				      <label for="product_move_left">Yes</label>
				      <input type="radio" id="product_move_right" name="product_move" value="0" <?=($permission->product_move==0?'checked':'')?>/>
				      <label for="product_move_right">No</label>
				    </div>
				</td>
				<td style="vertical-align: bottom;">
					<div style="padding: 5px">
						<input type="submit" name="submit5" value="Save" class="btn btn-success">
					</div>
				</td>
			</tr>
			<tr class="bg-info">
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Requirement<br/> form create?</b></div>
				      <input type="radio" id="form_add_left" name="form_add" value="1" <?=($permission->form_add==1?'checked':'')?>/>
				      <label for="form_add_left">Yes</label>
				      <input type="radio" id="form_add_right" name="form_add" value="0" <?=($permission->form_add==0?'checked':'')?>/>
				      <label for="form_add_right">No</label>
				    </div>
				</td>
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Form delete?</b></div>
				      <input type="radio" id="form_delete_left" name="form_delete" value="1" <?=($permission->form_delete==1?'checked':'')?>/>
				      <label for="form_delete_left">Yes</label>
				      <input type="radio" id="form_delete_right" name="form_delete" value="0" <?=($permission->form_delete==0?'checked':'')?>/>
				      <label for="form_delete_right">No</label>
				    </div>
				</td>
				<td colspan="6">
					<div class="switch-field">
				      <div class="switch-title"><b>Form List?</b></div>
				      <input type="radio" id="form_list_left" name="form_list" value="1" <?=($permission->form_list==1?'checked':'')?>/>
				      <label for="form_list_left">Yes</label>
				      <input type="radio" id="form_list_right" name="form_list" value="0" <?=($permission->form_list==0?'checked':'')?>/>
				      <label for="form_list_right">No</label>
				    </div>
				</td>
			</tr>
			<tr class="bg-warning">
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Department menu?</b></div>
				      <input type="radio" id="department_left" name="department" value="1" <?=($permission->department==1?'checked':'')?>/>
				      <label for="department_left">Yes</label>
				      <input type="radio" id="department_right" name="department" value="0" <?=($permission->department==0?'checked':'')?>/>
				      <label for="department_right">No</label>
				    </div>
				</td>
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Department add?</b></div>
				      <input type="radio" id="department_add_left" name="department_add" value="1" <?=($permission->department_add==1?'checked':'')?>/>
				      <label for="department_add_left">Yes</label>
				      <input type="radio" id="department_add_right" name="department_add" value="0" <?=($permission->department_add==0?'checked':'')?>/>
				      <label for="department_add_right">No</label>
				    </div>
				</td>
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Department edit?</b></div>
				      <input type="radio" id="department_edit_left" name="department_edit" value="1" <?=($permission->department_edit==1?'checked':'')?>/>
				      <label for="department_edit_left">Yes</label>
				      <input type="radio" id="department_edit_right" name="department_edit" value="0" <?=($permission->department_edit==0?'checked':'')?>/>
				      <label for="department_edit_right">No</label>
				    </div>
				</td>
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Department delete?</b></div>
				      <input type="radio" id="department_delete_left" name="department_delete" value="1" <?=($permission->department_delete==1?'checked':'')?>/>
				      <label for="department_delete_left">Yes</label>
				      <input type="radio" id="department_delete_right" name="department_delete" value="0" <?=($permission->department_delete==0?'checked':'')?>/>
				      <label for="department_delete_right">No</label>
				    </div>
				</td>
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Department list?</b></div>
				      <input type="radio" id="department_list_left" name="department_list" value="1" <?=($permission->department_list==1?'checked':'')?>/>
				      <label for="department_list_left">Yes</label>
				      <input type="radio" id="department_list_right" name="department_list" value="0" <?=($permission->department_list==0?'checked':'')?>/>
				      <label for="department_list_right">No</label>
				    </div>
				</td>
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Department trash list?</b></div>
				      <input type="radio" id="department_trash_left" name="department_trash" value="1" <?=($permission->department_trash==1?'checked':'')?>/>
				      <label for="department_trash_left">Yes</label>
				      <input type="radio" id="department_trash_right" name="department_trash" value="0" <?=($permission->department_trash==0?'checked':'')?>/>
				      <label for="department_trash_right">No</label>
				    </div>
				</td>
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Department trash to move?</b></div>
				      <input type="radio" id="department_move_left" name="department_move" value="1" <?=($permission->department_move==1?'checked':'')?>/>
				      <label for="department_move_left">Yes</label>
				      <input type="radio" id="department_move_right" name="department_move" value="0" <?=($permission->department_move==0?'checked':'')?>/>
				      <label for="department_move_right">No</label>
				    </div>
				</td>
				<td style="vertical-align: bottom;">
					<div style="padding: 5px">
						<input type="submit" name="submit6" value="Save" class="btn btn-success">
					</div>
				</td>
			</tr>
			<tr class="bg-info">
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Designation menu?</b></div>
				      <input type="radio" id="designation_left" name="designation" value="1" <?=($permission->designation==1?'checked':'')?>/>
				      <label for="designation_left">Yes</label>
				      <input type="radio" id="designation_right" name="designation" value="0" <?=($permission->designation==0?'checked':'')?>/>
				      <label for="designation_right">No</label>
				    </div>
				</td>
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Designation add?</b></div>
				      <input type="radio" id="designation_add_left" name="designation_add" value="1" <?=($permission->designation_add==1?'checked':'')?>/>
				      <label for="designation_add_left">Yes</label>
				      <input type="radio" id="designation_add_right" name="designation_add" value="0" <?=($permission->designation_add==0?'checked':'')?>/>
				      <label for="designation_add_right">No</label>
				    </div>
				</td>
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Designation edit?</b></div>
				      <input type="radio" id="designation_edit_left" name="designation_edit" value="1" <?=($permission->designation_edit==1?'checked':'')?>/>
				      <label for="designation_edit_left">Yes</label>
				      <input type="radio" id="designation_edit_right" name="designation_edit" value="0" <?=($permission->designation_edit==0?'checked':'')?>/>
				      <label for="designation_edit_right">No</label>
				    </div>
				</td>
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Designation delete?</b></div>
				      <input type="radio" id="designation_delete_left" name="designation_delete" value="1" <?=($permission->designation_delete==1?'checked':'')?>/>
				      <label for="designation_delete_left">Yes</label>
				      <input type="radio" id="designation_delete_right" name="designation_delete" value="0" <?=($permission->designation_delete==0?'checked':'')?>/>
				      <label for="designation_delete_right">No</label>
				    </div>
				</td>
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Designation list?</b></div>
				      <input type="radio" id="designation_list_left" name="designation_list" value="1" <?=($permission->designation_list==1?'checked':'')?>/>
				      <label for="designation_list_left">Yes</label>
				      <input type="radio" id="designation_list_right" name="designation_list" value="0" <?=($permission->designation_list==0?'checked':'')?>/>
				      <label for="designation_list_right">No</label>
				    </div>
				</td>
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Designation trash list?</b></div>
				      <input type="radio" id="designation_trash_left" name="designation_trash" value="1" <?=($permission->designation_trash==1?'checked':'')?>/>
				      <label for="designation_trash_left">Yes</label>
				      <input type="radio" id="designation_trash_right" name="designation_trash" value="0" <?=($permission->designation_trash==0?'checked':'')?>/>
				      <label for="designation_trash_right">No</label>
				    </div>
				</td>
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Designation trash to move?</b></div>
				      <input type="radio" id="designation_move_left" name="designation_move" value="1" <?=($permission->designation_move==1?'checked':'')?>/>
				      <label for="designation_move_left">Yes</label>
				      <input type="radio" id="designation_move_right" name="designation_move" value="0" <?=($permission->designation_move==0?'checked':'')?>/>
				      <label for="designation_move_right">No</label>
				    </div>
				</td>
				<td style="vertical-align: bottom;">
					<div style="padding: 5px">
						<input type="submit" name="submit7" value="Save" class="btn btn-success">
					</div>
				</td>
			</tr>
			<tr class="bg-warning">
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>User menu?</b></div>
				      <input type="radio" id="user_left" name="user" value="1" <?=($permission->user==1?'checked':'')?>/>
				      <label for="user_left">Yes</label>
				      <input type="radio" id="user_right" name="user" value="0" <?=($permission->user==0?'checked':'')?>/>
				      <label for="user_right">No</label>
				    </div>
				</td>
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>User add?</b></div>
				      <input type="radio" id="user_add_left" name="user_add" value="1" <?=($permission->user_add==1?'checked':'')?>/>
				      <label for="user_add_left">Yes</label>
				      <input type="radio" id="user_add_right" name="user_add" value="0" <?=($permission->user_add==0?'checked':'')?>/>
				      <label for="user_add_right">No</label>
				    </div>
				</td>
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>User edit?</b></div>
				      <input type="radio" id="user_edit_left" name="user_edit" value="1" <?=($permission->user_edit==1?'checked':'')?>/>
				      <label for="user_edit_left">Yes</label>
				      <input type="radio" id="user_edit_right" name="user_edit" value="0" <?=($permission->user_edit==0?'checked':'')?>/>
				      <label for="user_edit_right">No</label>
				    </div>
				</td>
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>User delete?</b></div>
				      <input type="radio" id="user_delete_left" name="user_delete" value="1" <?=($permission->user_delete==1?'checked':'')?>/>
				      <label for="user_delete_left">Yes</label>
				      <input type="radio" id="user_delete_right" name="user_delete" value="0" <?=($permission->user_delete==0?'checked':'')?>/>
				      <label for="user_delete_right">No</label>
				    </div>
				</td>
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>User list?</b></div>
				      <input type="radio" id="user_list_left" name="user_list" value="1" <?=($permission->user_list==1?'checked':'')?>/>
				      <label for="user_list_left">Yes</label>
				      <input type="radio" id="user_list_right" name="user_list" value="0" <?=($permission->user_list==0?'checked':'')?>/>
				      <label for="user_list_right">No</label>
				    </div>
				</td>
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>User trash list?</b></div>
				      <input type="radio" id="user_trash_left" name="user_trash" value="1" <?=($permission->user_trash==1?'checked':'')?>/>
				      <label for="user_trash_left">Yes</label>
				      <input type="radio" id="user_trash_right" name="user_trash" value="0" <?=($permission->user_trash==0?'checked':'')?>/>
				      <label for="user_trash_right">No</label>
				    </div>
				</td>
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>User trash to move?</b></div>
				      <input type="radio" id="user_move_left" name="user_move" value="1" <?=($permission->user_move==1?'checked':'')?>/>
				      <label for="user_move_left">Yes</label>
				      <input type="radio" id="user_move_right" name="user_move" value="0" <?=($permission->user_move==0?'checked':'')?>/>
				      <label for="user_move_right">No</label>
				    </div>
				</td>
				<td style="vertical-align: bottom;">
					<div style="padding: 5px">
						<input type="submit" name="submit8" value="Save" class="btn btn-success">
					</div>
				</td>
			</tr>
			<tr class="bg-info">
				<td colspan="8">
					<div class="switch-field">
				      <div class="switch-title"><b>User Privilege?</b></div>
				      <input type="radio" id="previlege_left" name="previlege" value="1" <?=($permission->previlege==1?'checked':'')?>/>
				      <label for="previlege_left">Yes</label>
				      <input type="radio" id="previlege_right" name="previlege" value="0" <?=($permission->previlege==0?'checked':'')?>/>
				      <label for="previlege_right">No</label>
				    </div>
				</td>
			</tr>
			<tr class="bg-warning">
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Reports menu?</b></div>
				      <input type="radio" id="report_left" name="report" value="1" <?=($permission->report==1?'checked':'')?>/>
				      <label for="report_left">Yes</label>
				      <input type="radio" id="report_right" name="report" value="0" <?=($permission->report==0?'checked':'')?>/>
				      <label for="report_right">No</label>
				    </div>
				</td>
				<td>
					<div class="switch-field">
				      <div class="switch-title"><b>Daily Task Report?</b></div>
				      <input type="radio" id="daily_task_report_left" name="daily_task_report" value="1" <?=($permission->daily_task_report==1?'checked':'')?>/>
				      <label for="daily_task_report_left">Yes</label>
				      <input type="radio" id="daily_task_report_right" name="daily_task_report" value="0" <?=($permission->daily_task_report==0?'checked':'')?>/>
				      <label for="daily_task_report_right">No</label>
				    </div>
				</td>
			</tr>
		</table>

		<div class="col-xs-12 text-center">
			<br/>
			<input type="submit" name="submit9" value="Save" class="btn btn-success btn-lg">
		</div>	
	</form>
</div>