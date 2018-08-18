<style type="text/css">
	.ui-datepicker-calendar {
	    display: none;
	}​
</style>
<style>
    table#main_table {
        border-collapse: collapse;
    }

    table#main_table, table#main_table tr th, table#main_table tr td {
        border: 1px solid black;
    }
    .page_title_text{display: none;}
</style>

<style>
    @media print {
        table#main_table {
            border-collapse: collapse;
            table-layout: fixed;
        }

        table#main_table, table#main_table tr th, table#main_table tr td {
            border: 1px solid black;
        }
        table#main_table tr td.sign {
            height: 100px;
            width:100px;
        }
    }
</style>
<div class="row calendar-exibit">
  <div class="col-xs-12" id="msg_area">
  	
  </div>	
  <div class="form-group col-md-4 col-md-offset-4">
	    <label>Select Month:</label>
	    <input type='text' id='txtDate' class="form-control" />
  </div>
  <div class="col-xs-12 text-center">
  		<input id="select" class="btn btn-success" value="Select" type="button">
	</div>
</div>
<div class="row">
	<div class="col-xs-12">
    <p class="page_title_text"><input type="button" value="Print" onclick="printDiv()" class="btn btn-primary"></p>
    <div id="plan_content">
      
    </div>
	</div>
</div>

<!--Insert Modal-->
<div class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-hidden="true" id="work_plan_add_customer">
  <div class="modal-dialog modal-md">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title" id="myModalLabel2">Add New</h4>
      </div>
      <div class="modal-body">
        <div id="message_show_area"></div>
        <form method="post" id="work_plan_add_form" action="<?=base_url('work-plan-event-ajax-add')?>">
          <input id="working_day_id" name="working_day_id" type="hidden">
          <input id="customer_id" name="customer_id" type="hidden">
          <input id="principle_id" name="principle_id" type="hidden">
          <div class="form-group">
            <label for="customer" class="control-label">Customer:</label>
            <div class="input-group">
            <input type="text" class="form-control" id="customer_for_work_plan" placeholder="Search Customer">
            <span class="input-group-addon"  id="clear_customer_list">
              <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
            </span>
            </div>
            <div id="customer_search_result">
            	<ul></ul>
            </div>
          </div>
          <div class="form-group">
            <label for="principle" class="control-label">Principle:</label>
            <div class="input-group">
            <input type="text" class="form-control" id="principle_for_work_plan" placeholder="Search Principle">
            <span class="input-group-addon"  id="clear_principle_list">
              <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
            </span>
            </div>
            <div id="principle_search_result">
              <ul></ul>
            </div>
          </div>
          <div class="form-group">
            <label for="estimated_event" class="control-label">Estimated Event:</label>
            <textarea class="form-control" name="estimated_event" id="estimated_event"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="save_event">Add Now</button>
      </div>

    </div>
  </div>
</div>