
var tabla;

//Función que se ejecuta al inicio
function init(){

    listar();
    //cuando se da click al boton submit entonces se ejecuta la funcion guardaryeditar(e);
    $("#pacienteHistorial_form").on("submit",function(e)
    {
        guardaryeditar(e);
    })

    //cambia el titulo de la ventana modal cuando se da click al boton
    $("#add_button").click(function(){

        $(".modal-title").text("Agregar Historial Clinico del Pacientes");

    });


}

//Función limpiar
function limpiar()
{
    $("#id_historial").val("");
    $('#paciente').val("");
    $('#padecimientos').val("");
    $('#alergias').val("");
    $('#datepicker2').val("");
    $('#receta').val("");
}

//Función Listar
function listar()
{
    tabla=$('#pacienteHistorial_data').dataTable(
        {
            "aProcessing": true,//Activamos el procesamiento del datatables
            "aServerSide": true,//Paginación y filtrado realizados por el servidor
            dom: 'Bfrtip',//Definimos los elementos del control de tabla
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdf'
            ],
            "ajax":
                {
                    url: '../ajax/pacienteHistorial.php?op=listar',
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
function mostrar(id_historial){
    $.post("../ajax/pacienteHistorial.php?op=mostrar",{id_historial : id_historial}, function(data, status)
    {
        data = JSON.parse(data);
            $('#pacienteHistorialModal').modal('show');
            $('#paciente').val(data.paciente);
            $("#paciente").attr('disabled', false);
            $('#padecimientos').val(data.padecimientos);
            $("#padecimientos").attr('disabled', false);
            $('#alergias').val(data.alergias);
            $("#alergias").attr('disabled', false);
            $('#datepicker2').val(data.datepicker2);
            $("#datepicker2").attr('disabled', false);
            $('#receta').val(data.receta);
            $("#receta").attr('disabled', false);
            $('.modal-title').text("Editar Historial del Paciente");
            $('#id_historial').val(id_historial);
            $('#btnGuardar').show(true);
            // $('.selectpicker').remove();
            // $('#paciente').remove(true);

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
//la funcion guardaryeditar(e); se llama cuando se da click al boton submit
function guardaryeditar(e)
{
    e.preventDefault(); //No se activará la acción predeterminada del evento
    var formData = new FormData($("#pacienteHistorial_form")[0]);


    $.ajax({
        url: "../ajax/pacienteHistorial.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function(datos)
        {
            /*bootbox.alert(datos);
            mostrarform(false);
            tabla.ajax.reload();*/

            //alert(datos);

            /*imprimir consulta en la consola debes hacer un print_r($_POST) al final del metodo
               y si se muestran los valores es que esta bien, y se puede imprimir la consulta desde el metodo
               y se puede ver en la consola o desde el mensaje de alerta luego pegar la consulta en phpmyadmin*/
            console.log(datos);

            $('#pacienteHistorial_form')[0].reset();
            $('#pacienteHistorialModal').modal('hide');

            $('#resultados_ajax').html(datos);
            $('#pacienteHistorial_data').DataTable().ajax.reload();

            limpiar();

        }

    });


}

//EDITAR ESTADO
function cambiarEstado(id_paciente, est){

}

//ELIMINAR PACIENTE
function eliminar(id_historial) {

    //alert;
    bootbox.confirm("¿Está Seguro de eliminar el Historial?", function (result) {
        if (result) {

            $.ajax({
                url: "../ajax/pacienteHistorial.php?op=eliminar_pacienteHistorial",
                method: "POST",
                data: {id_historial: id_historial},

                success: function (data) {
                    //alert(data);
                    $("#resultados_ajax").html(data);
                    $("#pacienteHistorial_data").DataTable().ajax.reload();
                }
            });
        }
    });
}



init();