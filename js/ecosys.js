$("#project-table1").DataTable({
    dom: 'lBfprtip',
    "paging":   true,
    "lengthMenu": [ [20, 50, 100, 500, 1000 ,-1], [20, 50, 100, 500, 1000, "All"] ],
    "searching":true,
    "stateSave": true,
    "order": [[ 0, "asc" ]],
    "buttons": [
        {
            extend: 'excel',
            exportOptions: {
                columns: ':visible'
            }
        },
        {
            extend: 'csv',
            exportOptions: {
                columns: ':visible'
            }
        },
        {
            extend: 'collection',
            text: 'Hide/Show Columns',
            buttons: [ 'columnsVisibility' ],
            visibility: true
        }
    ]
});

