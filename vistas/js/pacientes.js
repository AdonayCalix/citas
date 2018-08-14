
var tabla;

//Función que se ejecuta al inicio
function init(){

    listar();
    listarHistorial();

    //cuando se da click al boton submit entonces se ejecuta la funcion guardaryeditar(e);
    $("#paciente_form").on("submit",function(e)
    {
        guardaryeditar(e);
    })

    //cambia el titulo de la ventana modal cuando se da click al boton
    $("#add_button").click(function(){

        $(".modal-title").text("Agregar Pacientes");

    });


}

//Función limpiar
function limpiar()
{
    $("#identidad").val("");
    $('#nombre').val("");
    $('#apellido').val("");
    $('#genero').val("");
    $('#datepicker2').val("");
    $('#tipoSangre').val("");
    $('#edad').val("");
    $('#telefono').val("");
    $('#correo').val("");
    $('#direccion').val("");
    $('#id_paciente').val("");
    //limpia los checkbox
    $('input:checkbox').removeAttr('checked');
}

//Función Listar
function listar()
{
    tabla=$('#paciente_data').dataTable(
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
                    url: '../ajax/paciente.php?op=listar',
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

//Función Listar
function listarHistorial()
{
    tabla=$('#pacienteHistorial_data').dataTable(
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
                    url: '../ajax/paciente.php?op=listarHistorial',
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

//Mostrar datos en la ventana modal
function mostrar(id_paciente){
    $.post("../ajax/paciente.php?op=mostrar",{id_paciente : id_paciente}, function(data, status)

    {

        data = JSON.parse(data);

        //si existe la cedula_relacion entonces tiene relacion con otras tablas
        // if(data.identidad_relacion){
        //
        //     $('#pacienteModal').modal('show');
        //
        //     $('#identidad').val(data.identidad_relacion);
        //
        //     //desactiva el campo
        //     $("#identidad").attr('disabled', 'disabled');
        //
        //     $('#nombre').val(data.nombre);
        //
        //     //desactiva el campo
        //     $("#nombre").attr('disabled', 'disabled');
        //
        //     $('#apellido').val(data.apellido);
        //
        //     //desactiva el campo
        //     $("#apellido").attr('disabled', 'disabled');
        //
        //     $('#genero').val(data.genero);
        //     $('#datepicker2').val(data.datepicker2);
        //     $('#tipoSangre').val(data.tipoSangre);
        //     $('#edad').val(data.edad);
        //     $('#telefono').val(data.telefono);
        //     $('#correo').val(data.correo);
        //     $('#direccion').val(data.direccion);
        //     $('.modal-title').text("Editar Paci");
        //     $('#id_paciente').val(id_paciente);
        //
        // } else{

        $('#pacienteModal').modal('show');
        $('#identidad').val(data.identidad);
        $("#identidad").attr('disabled', false);
        $('#nombre').val(data.nombre);
        $("#nombre").attr('disabled', false);
        $('#apellido').val(data.apellido);
        $("#apellido").attr('disabled', false);
        $('#genero').val(data.genero);
        $("#genero").attr('disabled', false);
        $('#datepicker2').val(data.datepicker2);
        $("#datepicker2").attr('disabled', false);
        $('#tipoSangre').val(data.tipoSangre);
        $("#tipoSangre").attr('disabled', false);
        $('#edad').val(data.edad);
        $("#edad").attr('disabled', false);
        $('#telefono').val(data.telefono);
        $("#telefono").attr('disabled', false);
        $('#correo').val(data.correo);
        $("#correo").attr('disabled', false);
        $('#direccion').val(data.direccion);
        $("#direccion").attr('disabled', false);
        $('.modal-title').text("Editar Paciente");
        $('#id_paciente').val(id_paciente);
        $('#btnGuardar').show(true);

        // }

    });
}

//Mostrar detalles en la ventana modal
function mostrarDetalle(id_paciente){
    $.post("../ajax/paciente.php?op=mostrar",{id_paciente : id_paciente}, function(data, status)

    {

        data = JSON.parse(data);

        $('#pacienteModal').modal('show');
        $('#identidad').val(data.identidad);
        $("#identidad").attr('disabled', 'disabled');
        $('#nombre').val(data.nombre);
        $("#nombre").attr('disabled', 'disabled');
        $('#apellido').val(data.apellido);
        $("#apellido").attr('disabled', 'disabled');
        $('#genero').val(data.genero);
        $("#genero").attr('disabled', 'disabled');
        $('#datepicker2').val(data.datepicker2);
        $("#datepicker2").attr('disabled', 'disabled');
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
        $('.modal-title').text("Detalle Paciente");
        $('#id_paciente').val(id_paciente);
        $('#btnGuardar').hide(true);


    });
}
//la funcion guardaryeditar
function guardaryeditar(e)
{
    e.preventDefault(); //No se activará la acción predeterminada del evento
    var formData = new FormData($("#paciente_form")[0]);


    $.ajax({
        url: "../ajax/paciente.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function(datos)
        {
            console.log(datos);

            $('#paciente_form')[0].reset();
            $('#pacienteModal').modal('hide');

            $('#resultados_ajax').html(datos);
            $('#paciente_data').DataTable().ajax.reload();

            limpiar();

        }

    });


}

//EDITAR ESTADO
function cambiarEstado(id_paciente, est){

}

//ELIMINAR PACIENTE

function eliminar(id_paciente) {

    bootbox.confirm("¿Está Seguro de eliminar el Paciente?", function (result) {
        if (result) {

            $.ajax({
                url: "../ajax/paciente.php?op=eliminar_paciente",
                method: "POST",
                data: {id_paciente: id_paciente},

                success: function (data) {
                    //alert(data);
                    $("#resultados_ajax").html(data);
                    $("#paciente_data").DataTable().ajax.reload();
                }
            });

        }

    });//bootbox


}



init();