$("#project-table").DataTable({
    dom: 'Bfrtip',
    "paging":   false,
    "searching":false,
    "stateSave": true,
    "order": [[ 0, "asc" ]],
    "buttons": ['excel','csv'
       
    ]
    
});
