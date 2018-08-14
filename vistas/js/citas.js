
var tabla;
var tabla_citas;
var tabla_citas_mes;
var tabla_citas_medico;
var tabla_citas_fecha_mes;

//Función que se ejecuta al inicio
function init(){
    listar();
    //cuando se da click al boton submit entonces se ejecuta la funcion guardaryeditar(e);
    $("#cita_form").on("submit",function(e)
    {
        guardaryeditar(e);
    });

    //cambia el titulo de la ventana modal cuando se da click al boton
    $("#add_button").click(function(){
        $(".modal-title").text("Agregar Cita");
    });

}

//Función limpiar
function limpiar()
{
    $("#id_cita").val("");
    $('#paciente').val("");
    $('#lugar').val("");
    $('#medico').val("");
    $('#timepicker').val("");
    $('#datepicker2').val("");
    $('#medicamentos').val("");
    $('#prescripcion').val("");
    $('#sintomas').val("");
    $('#estado').val("");
}

//Función Listar
function listar()
{
    tabla=$('#cita_data').dataTable(
        {
            "aProcessing": true,//Activamos el procesamiento del datatables
            "aServerSide": true,//Paginación y filtrado realizados por el servidor
            dom: 'Bfrtip',//Definimos los elementos del control de tabla
            buttons: [
                'copyHtml5',
                'excelHtml5',
                // 'csvHtml5',
                'pdf'
            ],
            "ajax":
                {
                    url: '../ajax/cita.php?op=listar',
                    type : "get",
                    dataType : "json",
                    error: function(e){
                        console.log(e.responseText);
                    }
                },
            "bDestroy": true,
            "responsive": true,
            "bInfo":true,
            "iDisplayLength": 10,//Por cada 10 registros hace una paginación
            "order": [[ 0, "desc" ]],//Ordenar (columna,orden)

            "language": {

                "sProcessing":     "Procesando...",

                "sLengthMenu":     "Mostrar _MENU_ registros",

                "sZeroRecords":    "No se encontraron resultados",

                "sEmptyTable":     "Ningún dato disponible en esta tabla",

                "sInfo":           "Mostrando un total de _TOTAL_ registros",

                "sInfoEmpty":      "Mostrando un total de 0 registros",

                "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",

                "sInfoPostFix":    "",

                "sSearch":         "Buscar:",

                "sUrl":            "",

                "sInfoThousands":  ",",

                "sLoadingRecords": "Cargando...",

                "oPaginate": {

                    "sFirst":    "Primero",

                    "sLast":     "Último",

                    "sNext":     "Siguiente",

                    "sPrevious": "Anterior"

                },

                "oAria": {

                    "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",

                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"

                }

            }//cerrando language

        }).DataTable();
}

//Mostrar datos en el modal
function mostrar(id_cita){
    $.post("../ajax/cita.php?op=mostrar",{id_cita : id_cita}, function(data, status)
    {
        data = JSON.parse(data);
        $('#citaModal').modal('show');
        $('#paciente').val(data.paciente);
        $("#paciente").attr('disabled', false);
        $('#lugar').val(data.lugar);
        $("#lugar").attr('disabled', false);
        $('#medico').val(data.medico);
        $("#medico").attr('disabled', false);
        $('#timepicker').val(data.timepicker);
        $("#timepicker").attr('disabled', false);
        $('#datepicker2').val(data.datepicker2);
        $("#datepicker2").attr('disabled', false);
        $('#medicamentos').val(data.medicamentos);
        $("#medicamentos").attr('disabled', false);
        $('#prescripcion').val(data.prescripcion);
        $("#prescripcion").attr('disabled', false);
        $('#sintomas').val(data.sintomas);
        $("#sintomas").attr('disabled', false);
        $('#estado').val(data.estado);
        $("#estado").attr('disabled', false);
        $('.modal-title').text("Editar Cita del Paciente");
        $('#id_cita').val(id_cita);
        $('#btnGuardar').show(true);
    });
}

//Mostrar detalles en el modal
function mostrarDetalle(id_historial){
    $.post("../ajax/pacienteHistorial.php?op=mostrarDetalle",{id_historial : id_historial}, function(data, status)
    {
        data = JSON.parse(data);
        $('#detalle_paciente').modal('show');
        $('#identidad').val(data.identidad);
        $("#identidad").attr('disabled', 'disabled');
        $('#nombre').val(data.nombre);
        $("#nombre").attr('disabled', 'disabled');
        $('#apellido').val(data.apellido);
        $("#apellido").attr('disabled', 'disabled');
        $('#genero').val(data.genero);
        $("#genero").attr('disabled', 'disabled');
        $('#tipoSangre').val(data.tipoSangre);
        $("#tipoSangre").attr('disabled', 'disabled');
        $('#edad').val(data.edad);
        $("#edad").attr('disabled', 'disabled');
        $('#telefono').val(data.telefono);
        $("#telefono").attr('disabled', 'disabled');
        $('#correo').val(data.correo);
        $("#correo").attr('disabled', 'disabled');
        $('#direccion').val(data.direccion);
        $("#direccion").attr('disabled', 'disabled');
        $('#padecimientos1').val(data.padecimientos);
        $("#padecimientos1").attr('disabled', 'disabled');
        $('#alergias1').val(data.alergias);
        $("#alergias1").attr('disabled', 'disabled');
        $('#datepicker21').val(data.datepicker2);
        $("#datepicker21").attr('disabled', 'disabled');
        $('#receta1').val(data.receta);
        $("#receta1").attr('disabled', 'disabled');
        $('.modal-title').text("Detalle Historial de Paciente");
        $('#id_historial').val(id_historial);
        $('#identidad').remove(true);

    });
}
//la funcion guardaryeditar
function guardaryeditar(e)
{
    e.preventDefault(); //No se activará la acción predeterminada del evento
    var formData = new FormData($("#cita_form")[0]);


    $.ajax({
        url: "../ajax/cita.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function(datos)
        {
            console.log(datos);

            $('#cita_form')[0].reset();
            $('#citaModal').modal('hide');

            $('#resultados_ajax').html(datos);
            $('#cita_data').DataTable().ajax.reload();

            limpiar();
        }
    });


}

//EDITAR ESTADO DE LA CITA
function cambiarEstado(id_cita, est){

    bootbox.confirm("¿Está Seguro de cambiar de estado?", function(result){
        if(result)
        {
            $.ajax({
                url:"../ajax/cita.php?op=activarydesactivar",
                method:"POST",
                //toma el valor del id y del estado
                data:{id_cita:id_cita, est:est},
                success: function(data){
                    $('#cita_data').DataTable().ajax.reload();
                    $('#citas_fecha_data').DataTable().ajax.reload();
                    $('#citas_fecha_mes_data').DataTable().ajax.reload();
                }
            });
        }

    });

}

//ELIMINAR PACIENTE
function eliminar(id_cita) {

    //alert;
    bootbox.confirm("¿Está Seguro de eliminar la Cita?", function (result) {
        if (result) {

            $.ajax({
                url: "../ajax/cita.php?op=eliminar_cita",
                method: "POST",
                data: {id_cita: id_cita},

                success: function (data) {
                    //alert(data);
                    $("#resultados_ajax").html(data);
                    $("#cita_data").DataTable().ajax.reload();
                }
            });
        }
    });
}

//VER DETALLE CITA
$(document).on('click', '.detalle', function () {
    //toma el valor del id
    var id_cita = $(this).attr("id");

    $.ajax({
        url: "../ajax/cita.php?op=ver_detalle_cita",
        method: "POST",
        data: {id_cita: id_cita},
        cache: false,
        dataType: "json",
        success: function (data) {

            $("#identidad").html(data.identidad);
            $("#nombre").html(data.nombre);
            $("#apellido").html(data.apellido);
            $("#genero").html(data.genero);
            $("#edad").html(data.edad);
            $("#medicoDetalle").html(data.medicoDetalle);
            $("#lugarDet").html(data.lugarDet);
            $("#horaDet").html(data.horaDet);
            $("#fechaDet").html(data.fechaDet);
            $("#estadoDet").html(data.estadoDet);
            $("#fecha_ingresoDet").html(data.fecha_ingresoDet);
            $("#medicamentosDet").html(data.medicamentosDet);
            $("#prescripcionDet").html(data.prescripcionDet);
            $("#sintomasDet").html(data.sintomasDet);
            loa

        }
    })
});

//CONSULTA CITA POR FECHA
$(document).on("click", "#btn_cita_fecha", function () {

    var fecha_inicial = $("#datepicker").val();
    var fecha_final = $("#datepicker2").val();

    //validamos si existe las fechas entonces se ejecuta el ajax

    if (fecha_inicial != "" && fecha_final != "") {

        // BUSCA LAS CITAS POR FECHA
        tabla_citas = $('#citas_fecha_data').DataTable({


            "aProcessing": true,//Activamos el procesamiento del datatables
            "aServerSide": true,//Paginación y filtrado realizados por el servidor
            dom: 'Bfrtip',//Definimos los elementos del control de tabla
            buttons: [
                'copyHtml5',
                'excelHtml5',
                // 'csvHtml5',
                'pdf'
            ],

            "ajax": {
                url: "../ajax/cita.php?op=buscar_citas_fecha",
                type: "post",
                //dataType : "json",
                data: {fecha_inicial: fecha_inicial, fecha_final: fecha_final},
                error: function (e) {
                    console.log(e.responseText);

                },


            },

            "bDestroy": true,
            "responsive": true,
            "bInfo": true,
            "iDisplayLength": 10,//Por cada 10 registros hace una paginación
            "order": [[0, "desc"]],//Ordenar (columna,orden)

            "language": {

                "sProcessing": "Procesando...",

                "sLengthMenu": "Mostrar _MENU_ registros",

                "sZeroRecords": "No se encontraron resultados",

                "sEmptyTable": "Ningún dato disponible en esta tabla",

                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",

                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",

                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",

                "sInfoPostFix": "",

                "sSearch": "Buscar:",

                "sUrl": "",

                "sInfoThousands": ",",

                "sLoadingRecords": "Cargando...",

                "oPaginate": {

                    "sFirst": "Primero",

                    "sLast": "Último",

                    "sNext": "Siguiente",

                    "sPrevious": "Anterior"

                },

                "oAria": {

                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",

                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"

                }

            },

        });

    }
});

//CITAS POR MES
$(document).on("click", "#btn_cita_fecha_mes", function () {
    var mes = $("#mes").val();
    var ano = $("#ano").val();

    if (mes != "" && ano != "") {

        // BUSCA LAS CITAS POR FECHA
        tabla_citas_mes = $('#citas_fecha_mes_data').DataTable({

            "aProcessing": true,//Activamos el procesamiento del datatables
            "aServerSide": true,//Paginación y filtrado realizados por el servidor
            dom: 'Bfrtip',//Definimos los elementos del control de tabla
            buttons: [
                'copyHtml5',
                'excelHtml5',
                // 'csvHtml5',
                'pdf'
            ],
            "ajax": {
                url: "../ajax/cita.php?op=buscar_citas_fecha_mes",
                type: "post",
                data: {mes: mes, ano: ano},
                error: function (e) {
                    console.log(e.responseText);
                },
            },

            "bDestroy": true,
            "responsive": true,
            "bInfo": true,
            "iDisplayLength": 10,//Por cada 10 registros hace una paginación
            "order": [[0, "desc"]],//Ordenar (columna,orden)

            "language": {

                "sProcessing": "Procesando...",

                "sLengthMenu": "Mostrar _MENU_ registros",

                "sZeroRecords": "No se encontraron resultados",

                "sEmptyTable": "Ningún dato disponible en esta tabla",

                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",

                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",

                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",

                "sInfoPostFix": "",

                "sSearch": "Buscar:",

                "sUrl": "",

                "sInfoThousands": ",",

                "sLoadingRecords": "Cargando...",

                "oPaginate": {

                    "sFirst": "Primero",

                    "sLast": "Último",

                    "sNext": "Siguiente",

                    "sPrevious": "Anterior"

                },

                "oAria": {

                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",

                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"

                }

            },
        });

    }

});

//CITAS POR MEDICO
$(document).on("click", "#btn_cita_medico", function () {
    var medico = $("#medico").val();

    if (medico != "") {

        // BUSCA LAS CITAS POR FECHA
        tabla_citas_medico = $('#citas_medico_data').DataTable({
            "aProcessing": true,//Activamos el procesamiento del datatables
            "aServerSide": true,//Paginación y filtrado realizados por el servidor
            dom: 'Bfrtip',//Definimos los elementos del control de tabla
            buttons: [
                // 'copyHtml5',
                'excelHtml5',
                // 'csvHtml5',
                'pdf'
            ],
            "ajax": {
                url: "../ajax/cita.php?op=buscar_citas_medico",
                type: "post",
                data: {medico: medico},
                error: function (e) {
                    console.log(e.responseText);
                },
            },

            "bDestroy": true,
            "responsive": true,
            "bInfo": true,
            "iDisplayLength": 10,//Por cada 10 registros hace una paginación
            "order": [[0, "desc"]],//Ordenar (columna,orden)

            "language": {

                "sProcessing": "Procesando...",

                "sLengthMenu": "Mostrar _MENU_ registros",

                "sZeroRecords": "No se encontraron resultados",

                "sEmptyTable": "Ningún dato disponible en esta tabla",

                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",

                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",

                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",

                "sInfoPostFix": "",

                "sSearch": "Buscar:",

                "sUrl": "",

                "sInfoThousands": ",",

                "sLoadingRecords": "Cargando...",

                "oPaginate": {

                    "sFirst": "Primero",

                    "sLast": "Último",

                    "sNext": "Siguiente",

                    "sPrevious": "Anterior"

                },

                "oAria": {

                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",

                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"

                }

            },
        });

    }

});

//CITAS POR MES
$(document).on("click", "#btn_cita_mes", function () {
    var mes1 = $("#mes1").val();
    var ano1 = $("#ano1").val();

    if (mes1 != "" && ano1 != "") {

        // BUSCA LAS CITAS POR FECHA
        var tabla_citas_mes = $('#cita_mes_data').DataTable({

            "aProcessing": true,//Activamos el procesamiento del datatables
            "aServerSide": true,//Paginación y filtrado realizados por el servidor
            dom: 'Bfrtip',//Definimos los elementos del control de tabla
            buttons: [
                // 'copyHtml5',
                'excelHtml5',
                // 'csvHtml5',
                'pdf'
            ],
            "ajax": {
                url: "../ajax/cita.php?op=buscar_citas_mes",
                type: "post",
                data: {mes1: mes1, ano1: ano1},
                error: function (e) {
                    console.log(e.responseText);
                },
            },

            "bDestroy": true,
            "responsive": true,
            "bInfo": true,
            "iDisplayLength": 10,//Por cada 10 registros hace una paginación
            "order": [[0, "desc"]],//Ordenar (columna,orden)

            "language": {

                "sProcessing": "Procesando...",

                "sLengthMenu": "Mostrar _MENU_ registros",

                "sZeroRecords": "No se encontraron resultados",

                "sEmptyTable": "Ningún dato disponible en esta tabla",

                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",

                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",

                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",

                "sInfoPostFix": "",

                "sSearch": "Buscar:",

                "sUrl": "",

                "sInfoThousands": ",",

                "sLoadingRecords": "Cargando...",

                "oPaginate": {

                    "sFirst": "Primero",

                    "sLast": "Último",

                    "sNext": "Siguiente",

                    "sPrevious": "Anterior"

                },

                "oAria": {

                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",

                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"

                }

            },
        });

    }

});

init();