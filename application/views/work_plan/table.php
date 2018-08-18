
<table class="table table-bordered table-responsive" id="main_table">
	<thead>
		<tr>
			<th>Date</th>
			<th>Plan Details</th>
		</tr>
	</thead>

<?php
$CI =& get_instance();
foreach($data as $k=>$val){
?>
	<tr>
		<td><?=nice_date($val->work_date,"d/m/Y")?></td>
		<td>
			<button class="btn btn-success btn-xs" data-id="<?=$val->id?>" data-toggle="modal" data-target="#work_plan_add_customer" >Setup</button>
			<div id="result_<?=$val->id?>">
				<?php
					$CI->plan_detail_by_plan_details_id($val->id,$val->work_date);
				?>
			</div>
		</td>
	</tr>
<?php
}
?>
</table>