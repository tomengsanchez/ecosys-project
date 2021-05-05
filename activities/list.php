<?php 
//define( 'WP_DEBUG', true );
global $searchQ; 

$userQuery = new WP_User_Query( $searchQ );
$result = $userQuery->get_results();
$controlNumbers = array();
foreach($result as $r){
    array_push($controlNumbers,$r->user_login . "/" . $r->last_name . "," . $r->first_name);
}
//print_r($controlNumbers);

?>
<h5>Activity List</h5>
<script>
jQuery(document).ready(function(){
    jQuery("#list").dataTable();
    jQuery('#addNewEvents').click(function(){
        jQuery('#addNewEventsModal').modal('toggle');
    });
    

    jQuery("#addToTable").click(function(){
        ctrl = jQuery("#controlNumbersInput").val();
        var ctrl = ctrl.split('/');
        jQuery("#attendeesTable tbody").append("<tr><td>" + ctrl[0] + "</td><td>" + ctrl[1] + "</td><td><input type='checkbox' id='check-" + ctrl[0]+ "' class='selectedAttendees'></td></tr>");

    });

    jQuery("#close").click(function(){
        
        
    });
});

jQuery( function() {
    var controlNumbersAuto = <?php echo json_encode($controlNumbers);?>;
    jQuery( "#controlNumbersInput" ).autocomplete({
    source: controlNumbersAuto,
    appendTo : $('#controlNumbersDiv')
    });
} );
</script>
<hr>
<button class='button' id='addNewEvents'>Add New Events</button>
<hr>
<table id='list' class='fluid'>
    <thead>
        <th>Date</th>    
        <th>Type</th>
        <th>Coordinator</th>
        <th>Location</th>
    </thead>
    <tbody>
    </tbody>
    <tfoot>
        <th>Date</th>    
        <th>Type</th>
        <th>Coordinator</th>
        <th>Location</th>
    </tfoot>
</table>

<div class='modal fade' id='addNewEventsModal' role='dialog'>
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class='modal-header'>
                <h5 class="modal-title" id="exampleModalLongTitle">Add New Events</h5>
            </div>
            <div class='modal-body'>
                
                    <div class="form-group row">
                        <label for='eventsDate' class='col-sm-2 col-form-label'>Date</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control-date form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for='eventsType' class='col-sm-2 col-form-label'>Type</label>
                        <div class="col-sm-10">
                            <select name="eventsType" id="eventsType" class='form-control' >
                                <option>SCM-1 Open Forum</option>
                                <option>SES</option>
                                <option>SCM-2 Open Forum</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for='eventsCoordinator' class='col-sm-2 col-form-label'>Coordinator</label>
                        <div class="col-sm-10">
                            <input type='text' id='eventsCoordinator' class='form-control'>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for='eventsLocation' class='col-sm-2 col-form-label'>Location</label>
                        <div class="col-sm-10">
                            <input type='text' id='eventsLocation' class='form-control'>
                        </div>
                    </div>
                    <hr>
                    <hr>
                    <h5>Please Select Attendees</h5>
                        <div class="form-group row">
                            <label for="controlNumbersInput" class='col-sm-2'>Tags: </label>
                            <input id="controlNumbersInput" class='col-sm-8' class='form-control' size='20'>
                            <button class='button' id='addToTable' class='form-control col-sm-2'>Add</button>
                            <div id='controlNumbersDiv'></div>
                        </div>
                    <div class='div'>
                        <table class="table" id='attendeesTable'>
                            <thead>
                                <tr>
                                    <th>Control Number</th>
                                    <th>Name</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        
                    </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id='save'>Save</button>
                <button type="button" class="btn btn-secondary" id='close' data-dismiss="modal" dispose='modal'>Close</button>
            </div>
        </div>
    </div>
</div>