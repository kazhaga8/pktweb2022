/**
 * Theme: Zircos Admin Template
 * Author: Coderthemes
 * Form Pickers
 */
jQuery(document).ready(function () {

    // Date Picker
    jQuery('.datepickers').datepicker({
        format: "dd/mm/yyyy",
        autoclose: true,
        todayHighlight: true,
        locale: {
            format: 'DD/MM/YYYY'
        },
    });
    // jQuery('#datepicker-autoclose').datepicker({
    //     autoclose: true,
    //     todayHighlight: true
    // });
    // jQuery('#datepicker-inline').datepicker();
    // jQuery('#datepicker-multiple-date').datepicker({
    //     format: "mm/dd/yyyy",
    //     clearBtn: true,
    //     multidate: true,
    //     multidateSeparator: ","
    // });
    // jQuery('#date-range').datepicker({
    //     toggleActive: true
    // });

    
    // //Date range picker
    $('.datepickerrange').daterangepicker({
        buttonClasses: ['btn', 'btn-sm'],
        applyClass: 'btn-success',
        cancelClass: 'btn-default',
        locale: {
            format: 'DD/MM/YYYY'
        },
    });
    $('.datetimepickerrange').daterangepicker({
        timePicker: true,
        timePickerIncrement: 30,
        locale: {
            format: 'DD/MM/YYYY h:mm A'
        },
        buttonClasses: ['btn', 'btn-sm'],
        applyClass: 'btn-success',
        cancelClass: 'btn-default'
    });
    // $('.input-limit-datepicker').daterangepicker({
    //     format: 'MM/DD/YYYY',
    //     minDate: '06/01/2015',
    //     maxDate: '06/30/2015',
    //     buttonClasses: ['btn', 'btn-sm'],
    //     applyClass: 'btn-success',
    //     cancelClass: 'btn-default',
    //     dateLimit: {
    //         days: 6
    //     }
    // });


});