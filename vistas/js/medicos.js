var tabla;

//Función que se ejecuta al inicio
function init(){

    listar();
    //cuando se da click al boton submit entonces se ejecuta la funcion guardaryeditar(e);
    $("#medico_form").on("submit",function(e)
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
    tabla=$('#medico_data').dataTable(
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
                    url: '../ajax/medico.php?op=listar',
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
function mostrar(id_medico){
    $.post("../ajax/medico.php?op=mostrar",{id_medico : id_medico}, function(data, status)

    {

        data = JSON.parse(data);

        $('#medicoModal').modal('show');
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
        $('#edad').val(data.edad);
        $("#edad").attr('disabled', false);
        $('#telefono').val(data.telefono);
        $("#telefono").attr('disabled', false);
        $('#correo').val(data.correo);
        $("#correo").attr('disabled', false);
        $('#direccion').val(data.direccion);
        $("#direccion").attr('disabled', false);
        $('#especialidad').val(data.especialidad);
        $("#especialidad").attr('disabled', false);
        $('.modal-title').text("Editar Medico");
        $('#id_medico').val(id_medico);
        $('#btnGuardar').show(true);

    });
}

//Mostrar detalles en la ventana modal
function mostrarDetalle(id_medico){
    $.post("../ajax/medico.php?op=mostrar",{id_medico : id_medico}, function(data, status)

    {

        data = JSON.parse(data);

        $('#medicoModal').modal('show');
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
        $('#edad').val(data.edad);
        $("#edad").attr('disabled', 'disabled');
        $('#telefono').val(data.telefono);
        $("#telefono").attr('disabled', 'disabled');
        $('#correo').val(data.correo);
        $("#correo").attr('disabled', 'disabled');
        $('#direccion').val(data.direccion);
        $("#direccion").attr('disabled', 'disabled');
        $('#especialidad').val(data.especialidad);
        $("#especialidad").attr('disabled', 'disabled');
        $('.modal-title').text("Detalle Medico");
        $('#id_medico').val(id_medico);
        $('#btnGuardar').hide(true);


    });
}
//la funcion guardaryeditar(e); se llama cuando se da click al boton submit
function guardaryeditar(e)
{
    e.preventDefault(); //No se activará la acción predeterminada del evento
    var formData = new FormData($("#medico_form")[0]);


    $.ajax({
        url: "../ajax/medico.php?op=guardaryeditar",
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

            $('#medico_form')[0].reset();
            $('#medicoModal').modal('hide');

            $('#resultados_ajax').html(datos);
            $('#medico_data').DataTable().ajax.reload();

            limpiar();

        }

    });


}

//EDITAR ESTADO
function cambiarEstado(id_paciente, est){

}

//ELIMINAR PACIENTE
function eliminar(id_medico) {

    //alert;
    bootbox.confirm("¿Está Seguro de eliminar al medico?", function (result) {
        if (result) {

            $.ajax({
                url: "../ajax/medico.php?op=eliminar_medico",
                method: "POST",
                data: {id_medico: id_medico},

                success: function (data) {
                    //alert(data);
                    $("#resultados_ajax").html(data);
                    $("#medico_data").DataTable().ajax.reload();
                }
            });
        }
    });
}

init();