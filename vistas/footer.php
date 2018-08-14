<!--Start  Footer -->
<footer class="footer-main"> 2018 &copy; Negocios Web.</footer>
<!--End footer -->
</div>
<!--End main content -->
<!--Begin core plugin -->
<script src="../public/assets/js/jquery.min.js"></script>
<script src="../public/assets/js/bootstrap.min.js"></script>
<script src="../public/assets/plugins/moment/moment.js"></script>
<script src="../public/assets/js/jquery.slimscroll.js"></script>
<script src="../public/assets/js/jquery.nicescroll.js"></script>
<script src="../public/assets/js/functions.js"></script>
<script src="../public/assets/pages/validation-custom.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.16/r-2.2.0/sl-1.2.3/datatables.min.js"></script>

<!--<script src="../public/vendors/js/jquery.dataTables.min.js"></script>-->
<script src="../public/vendors/js/bootstrap-select.min.js"></script>
<script src="../public/vendors/js/select2.js"></script>

<!--<script src="../public/vendors/js/jquery.dataTables.min.js"></script>-->
<!--<script src="../public/vendors/js/bootstrap-select.min.js"></script>-->

<!--<script src="../public/datatables/jquery.dataTables.min.js"></script>-->
<script src="../public/datatables/dataTables.buttons.min.js"></script>
<script src="../public/datatables/buttons.html5.min.js"></script>
<script src="../public/datatables/buttons.colVis.min.js"></script>
<script src="../public/datatables/jszip.min.js"></script>
<script src="../public/datatables/pdfmake.min.js"></script>
<script src="../public/datatables/vfs_fonts.js"></script>
<!--BOOTSTRAP FILE STYLE-->
<script src="../public/vendors/js/bootstrap-filestyle.js"></script>
<!-- datepicker -->
<script src="../public/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!--LIBRERIA DE MENSAJE MODAL-->
<script src="js/bootbox.min.js"></script>
<!-- End core plugin -->
<script>
    $(":file").filestyle({input: false, buttonText: "Agregar Imagen",buttonName: "btn-primary"});
</script>
<script src="../public/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="../public/assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="../public/assets/plugins/timepicker/bootstrap-timepicker.js"></script>
<script src="../public/assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<script src="../public/assets/plugins/clockpicker/js/bootstrap-clockpicker.min.js"></script>
<script>
    // Time Picker
    jQuery('#timepicker').timepicker({
        defaultTIme : false
    });
    jQuery('#timepicker2').timepicker({
        showMeridian : false
    });
    jQuery('#timepicker3').timepicker({
        minuteStep : 15
    });

    //colorpicker start

    $('.colorpicker-default').colorpicker({
        format: 'hex'
    });
    $('.colorpicker-rgba').colorpicker();

    // Date Picker
    jQuery('#datepicker').datepicker();
    jQuery('#datepicker-autoclose').datepicker({
        autoclose: true,
        todayHighlight: true
    });
    jQuery('#datepicker-inline').datepicker();
    jQuery('#datepicker-multiple-date').datepicker({
        format: "mm/dd/yyyy",
        clearBtn: true,
        multidate: true,
        multidateSeparator: ","
    });
    jQuery('#date-range').datepicker({
        toggleActive: true
    });

    //Clock Picker
    $('.clockpicker').clockpicker({
        donetext: 'Done'
    });

    $('#single-input').clockpicker({
        placement: 'bottom',
        align: 'left',
        autoclose: true,
        'default': 'now'
    });
    $('#check-minutes').click(function(e){
        // Have to stop propagation here
        e.stopPropagation();
        $("#single-input").clockpicker('show')
            .clockpicker('toggleView', 'minutes');
    });


    //Date range picker
    $('.input-daterange-datepicker').daterangepicker({
        buttonClasses: ['btn', 'btn-sm'],
        applyClass: 'btn-default',
        cancelClass: 'btn-white'
    });
    $('.input-daterange-timepicker').daterangepicker({
        timePicker: true,
        timePickerIncrement: 30,
        locale: {
            format: 'MM/DD/YYYY h:mm A'
        },
        buttonClasses: ['btn', 'btn-sm'],
        applyClass: 'btn-default',
        cancelClass: 'btn-white'
    });
    $('.input-limit-datepicker').daterangepicker({
        format: 'MM/DD/YYYY',
        minDate: '06/01/2015',
        maxDate: '06/30/2015',
        buttonClasses: ['btn', 'btn-sm'],
        applyClass: 'btn-default',
        cancelClass: 'btn-white',
        dateLimit: {
            days: 6
        }
    });

    $('#reportrange span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));

    $('#reportrange').daterangepicker({
        format: 'MM/DD/YYYY',
        startDate: moment().subtract(29, 'days'),
        endDate: moment(),
        minDate: '01/01/2012',
        maxDate: '12/31/2015',
        dateLimit: {
            days: 60
        },
        showDropdowns: true,
        showWeekNumbers: true,
        timePicker: false,
        timePickerIncrement: 1,
        timePicker12Hour: true,
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        opens: 'left',
        drops: 'down',
        buttonClasses: ['btn', 'btn-sm'],
        applyClass: 'btn-default',
        cancelClass: 'btn-white',
        separator: ' to ',
        locale: {
            applyLabel: 'Submit',
            cancelLabel: 'Cancel',
            fromLabel: 'From',
            toLabel: 'To',
            customRangeLabel: 'Custom',
            daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
            monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            firstDay: 1
        }
    }, function (start, end, label) {
        console.log(start.toISOString(), end.toISOString(), label);
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    });
</script>
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
    $('.alert').alert()

    $('.selectpicker').selectpicker({
        style: 'btn btn-info outline-btn',
        size: 4
    });

</script>

<!--CAMPO FECHA - DATEPICKER-->

<script>

    $('#datepicker').datepicker({
        /*dateFormat: 'dd-mm-yy',
        autoclose: true*/
        format: "dd/mm/yyyy",
        /*clearBtn: true,
        language: "es",*/
        autoclose: true,
        /*keyboardNavigation: false,
        todayHighlight: true*/
    })


    /*EN EL SEGUNDO CAMPO*/
    $('#datepicker2').datepicker({
        /*dateFormat: 'dd-mm-yy',
        autoclose: true*/
        format: "dd/mm/yyyy",
        clearBtn: true,
        language: "es",
        autoclose: true,
        keyboardNavigation: false,
        todayHighlight: true
    })

</script>
</body>
<!-- Mirrored from mixtheme.com/mixtheme/meter/table-responsive.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 11 Jun 2017 19:30:25 GMT -->
</html>
<script type="text/javascript">
    $(document).ready(function () {
        // $('#tipoSangre').select2();
        $("#tipoSangre").select2({ maximumSelectionSize: 3 });
    });

</script>


