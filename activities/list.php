<?php 
//define( 'WP_DEBUG', true );


?>
<h5>Activity List</h5>
<script>
jQuery(document).ready(function(){
    jQuery("#list").dataTable();
    jQuery('#addNewEvents').click(function(){
        jQuery('#addNewEventsModal').modal('toggle');
    });
    
});

$( function() {
    var availableTags = [
    "ActionScript",
    "AppleScript",
    "Asp",
    "BASIC",
    "C",
    "C++",
    "Clojure",
    "COBOL",
    "ColdFusion",
    "Erlang",
    "Fortran",
    "Groovy",
    "Haskell",
    "Java",
    "JavaScript",
    "Lisp",
    "Perl",
    "PHP",
    "Python",
    "Ruby",
    "Scala",
    "Scheme"
    ];
    $( "#tags" ).autocomplete({
    source: availableTags,
    appendTo : $('#tagsDiv')
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
                            <input type="date" class="form-control-date">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for='eventsType' class='col-sm-2 col-form-label'>Type</label>
                        <div class="col-sm-10">
                            <select name="eventsType" id="eventsType">
                                <option>SCM-1 Open Forum</option>
                                <option>SES</option>
                                <option>SCM-2 Open Forum</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for='eventsCoordinator' class='col-sm-2 col-form-label'>Coordinator</label>
                        <div class="col-sm-10">
                            <input type='text' id='eventsCoordinator'>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for='eventsLocation' class='col-sm-2 col-form-label'>Location</label>
                        <div class="col-sm-10">
                            <input type='text' id='eventsLocation'>
                        </div>
                    </div>
                    <hr>
                    
                        
                       
                    <hr>
                    <h5>Please Select Attendees</h5>
                        <div class="ui-widget">
                            <label for="tags">Tags: </label>
                            <input id="tags">
                            <th><button class='button'>Add</button></th>
                            <div id='tagsDiv'></div>
                        </div>
                    <div class='div'>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Control Number</th>
                                    <th>Name</th>
                                    
                                </tr>
                                
                            </thead>
                        </table>
                        
                    </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id='save'>Save</button>
                <button type="button" class="btn btn-secondary" id='close' data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>