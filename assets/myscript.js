jQuery(document).ready(function($){
    //document ready
    //initialise the datepicker plugin

    if($('.cdatepicker').val() !== undefined )
    {
        $('.cdatepicker').cdatepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        })
    }

    if($('.datatable').val() !== undefined)
    {
        $(".datatable").DataTable();
    }
})
