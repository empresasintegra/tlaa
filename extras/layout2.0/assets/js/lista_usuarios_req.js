$(document).ready(function(){

 
  $("#example1").dataTable({
    scrollY:        "400px",
    scrollX:        true,
    scrollCollapse: true,
    paging:         false,            
    fixedColumns:   {
      leftColumns: 1,
      rightColumns: 1
    },
    retrieve: true,
  });
  $("#example2").dataTable({
    scrollY:        "400px",
    scrollX:        true,
    scrollCollapse: true,
    paging:         false,            
    fixedColumns:   {
      leftColumns: 1,
      rightColumns: 1
    },
    retrieve: true,
  });

  $("#example3").dataTable({
    scrollY:        true,
    scrollX:        true,
    scrollCollapse: true,
    paging:         false,
    fixedColumns:   {
      leftColumns: 0,
      rightColumns: 0
    },            
    retrieve: true,
  });
  $("#example4").dataTable({
    scrollY:        "400px",
    scrollX:        true,
    scrollCollapse: true,
    paging:         false, 
    fixedColumns:   {
      leftColumns: 1,
      rightColumns: 1
    },           
    retrieve: true,
  });
  $("#example5").dataTable({
    scrollY:        "400px",
    scrollX:        true,
    scrollCollapse: true,
    paging:         false,            
    fixedColumns:   {
      leftColumns: 1,
      rightColumns: 1
    },
    retrieve: true,
  });
 });