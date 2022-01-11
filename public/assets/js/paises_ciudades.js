$(document).ready(function() {
    // por comodidad puedes asignar los selects a una variable, ya que los vas a usar mas de una vez
    var paisSelect = $('#cod_pais');
    var ciudadSelect = $('#id_ciudad');
    var botonr = $('#reset')
        // primero obtienes los paises y llenas el select
    function PaisesSelect() {
        $.ajax({
            url: "/pages/agentes/getPaises",
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                $.each(response.data, function(key, value) {
                    pais.append("<option value='" + value.cod + "'>" + value.pais + "</option>");
                });
            },
            error: function() {
                alert('Hubo un error obteniendo los Paises!');
            }
        });
    }
    PaisesSelect();
    // luego indicas que cuando se seleccione un pais, se obtengan las ciudades correspondientes y se llene el select de Ciudades
    pais.change(function() {
        var paisCod = paisSelect.val();
        ciudad.empty();
        if (paisCod) {
            $.ajax({
                url: "/pages/agentes/getCiudades",
                type: 'GET',
                data: { cod_pais: paisCod },
                dataType: 'json',
                success: function(response) {
                    ciudad.append('<option value="">--Seleccione--</option>')
                    $.each(response.data, function(key, value) {
                        ciudad.append("<option value='" + value.ciudad_id + "'>" + value.ciudad + "</option>");
                    });
                },
                error: function() {
                    alert('Hubo un error obteniendo las areas!');
                }
            });
        }
    });

    function limpiarSelects() {
        paisSelect.empty();
        paisSelect.append('<option value="">--Seleccione--</option>')
        PaisesSelect();
        ciudad.empty();
        ciudad.append('<option value="">--Seleccione--</option>')
    }

    botonr.click(function() { // apply to reset button's click event
        limpiarSelects();
    });
});