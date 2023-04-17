//Eliminar todos los registros
function EliminarAll() {
    $.ajax({
        url: "indicadores/eliminarAll/",
        beforeSend: function() {
            $('#btnEliminarAll').text('Eliminando...');
        },
        success: function(data) {
            setTimeout(function() {
                $('#confirmModal').modal('hide');
                toastr.warning('Se han eliminado todos los registros.',
                    'Eliminar Registros', {
                        timeOut: 2000
                    });
                $('#tabla-indicadores').DataTable().ajax.reload();
                $('#btnEliminarAll').text('Eliminar todos los registros');
                $('#btnMostrar').prop('disabled', false);
                $('#btnEliminarAll').prop('disabled', true);
            }, 1000);
        }
    });
}

//Mostrar datos de API
function Mostrar() {
    $(this).prop('disabled', true);
    $.ajax({
        url: "indicadores/mostrar",
        beforeSend: function() {
            $('#btnMostrar').text('Cargando...');
        },
        success: function(data) {
            toastr.success('Se han obtenido los datos exitosamente',
                'Indicadores', {
                    timeOut: 2000
                });
        },
        error: function(jqXHR, textStatus, errorThrown) {
            toastr.error('hubo un error al obtener los datos',
                'Indicadores', {
                    timeOut: 2000
                });
        },
        complete: function() {
            $('#tabla-indicadores').DataTable().ajax.reload();
            $('#btnEliminarAll').prop('disabled', false);
            $('#btnMostrar').prop('disabled', true);
            $('#btnMostrar').text('Consumir API Indicadores');
        }
    });
}

//Editar Indicador
function editarIndicadores(id) {
    $.get('indicadores/editar/' + id, function(indicadores) {
        $('#id2').val(indicadores[0].id)
        $('#nom_ind2').val(indicadores[0].nombreIndicador)
        $('#cod_ind2').val(indicadores[0].codigoIndicador)
        $('#um_ind2').val(indicadores[0].unidadMedidaIndicador)
        $('#valor_ind2').val(indicadores[0].valorIndicador)
        $('#fech_ind2').val(indicadores[0].fechaIndicador)
        $('#ori_ind2').val(indicadores[0].origenIndicador)

        $('#editar_modal').modal('toggle');
    })
}




var id_ind;
$(document).on('click', '.delete', function Eliminar() {

    id_ind = $(this).attr('id');
    $('#confirmModal').modal('show');

});
//Eliminar indicador
function btnEliminar() {
    debugger;
    $.ajax({
        url: "indicadores/eliminar/" + id_ind,
        beforeSend: function() {
            $('#btnEliminar').text('Eliminando...');
        },
        success: function(data) {
            setTimeout(function() {
                $('#confirmModal').modal('hide');
                toastr.warning('El registro fue eliminado correctamente.',
                    'Eliminar Registro', {
                        timeOut: 2000
                    });
                $('#tabla-indicadores').DataTable().ajax.reload();
                $('#btnEliminar').text('Eliminar');
            }, 1000);
        }
    });
}
//Registrar nuevo indicador
function Registrar() {
    var nombreIndicador = $('#nom_ind').val();
    var codigoIndicador = $('#cod_ind').val();
    var unidadMedidaIndicador = $('#um_ind').val();
    var valorIndicador = $('#valor_ind').val();
    var fechaIndicador = $('#fech_ind').val();
    var origenIndicador = $('#ori_ind').val();
    var _token = $("input[name=_token").val();

    $.ajax({
        url: "indicadores",
        type: "POST",
        data: {
            nombreIndicador: nombreIndicador,
            codigoIndicador: codigoIndicador,
            unidadMedidaIndicador: unidadMedidaIndicador,
            valorIndicador: valorIndicador,
            fechaIndicador: fechaIndicador,
            origenIndicador: origenIndicador,
            _token: _token,
        },
        success: function(response) {
            if (response) {
                $('#registro-indicadores')[0].reset();
                toastr.success('El registro se ingreso correctamente.', 'Nuevo Registro', {
                    timeOut: 3000
                });
                $('#tabla-indicadores').DataTable().ajax.reload();
            }
        }
    });
}
// Actualizar registro
function Actualizar() {
    var id2 = $('#id2').val();
    var nombreIndicador2 = $('#nom_ind2').val();
    var codigoIndicador2 = $('#cod_ind2').val();
    var unidadMedidaIndicador2 = $('#um_ind2').val();
    var valorIndicador2 = $('#valor_ind2').val();
    var fechaIndicador2 = $('#fech_ind2').val();
    var origenIndicador2 = $('#ori_ind2').val();
    var _token2 = $("input[name=_token]").val();
    $.ajax({
        url: "indicadores/actualizar",
        type: "POST",
        data: {
            id: id2,
            nombreIndicador: nombreIndicador2,
            codigoIndicador: codigoIndicador2,
            unidadMedidaIndicador: unidadMedidaIndicador2,
            valorIndicador: valorIndicador2,
            fechaIndicador: fechaIndicador2,
            origenIndicador: origenIndicador2,
            _token: _token2,
        },
        success: function(response) {

            if (response) {
                $('#editar_modal').modal('hide');
                toastr.info('El registro fue actualizado correctamente.',
                    'Actualizar Registro', {
                        timeOut: 3000
                    });
                $('#tabla-indicadores').DataTable().ajax.reload();



            }
        }
    })
}
// Gráfico
function obtenerFecha() {
    const fechas = $('#tabla-indicadores').DataTable().column(5).data().toArray();
    const valores = $('#tabla-indicadores').DataTable().column(4).data().toArray();
    const xyValues = fechas.map((fecha, index) => [fecha, valores[index]]);
    new Chart("myChart", {
        type: "line",
        data: {
            labels: fechas,
            datasets: [{
                label: 'Valores de UF',
                backgroundColor: "rgba(0,0,255,1.0)",
                borderColor: "rgba(0,0,255,0.1)",
                data: valores
            }]
        },
        options: {}
    });
}