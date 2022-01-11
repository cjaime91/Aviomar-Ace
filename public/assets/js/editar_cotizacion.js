$(document).ready(function() {
    var tipo_cot = $('#tcotizacion');
    var fecha = $('#fecha');
    var consecutivo = $('#consecutivo');
    var tipo_trans = $('#ttrans_id');
    var num_ref = $('#num_ref');
    var cbm_in = $('#dis_cbm');
    var cbm_a_m = $('#dis_am');
    var lib_in = $('#lib_cbm');
    var lib_a_m = $('#lib_am');
    var producto = $('#producto_id');
    var tipooper = $('#toper_id');
    var cliente = $('#tcliente_id')
    var pais_or = $('#cod_pais_or')
    var ciudad_or = $('#ciudad_id_or')
    var pais_ds = $('#cod_pais_ds')
    var ciudad_ds = $('#ciudad_id_ds')
    var cbm_c = $('#cbm')
    var cbm_a = $('#cbm_a')
    var cbm_m = $('#cbm_m')
    var lib = $('#libras')
    var lib_a = $('#libras_a')
    var lib_m = $('#libras_m')


    tipo_cot.select2();
    tipo_trans.select2();
    producto.select2();
    tipooper.select2();
    cliente.select2();
    pais_or.select2();
    ciudad_or.select2();
    pais_ds.select2();
    ciudad_ds.select2();
    $('#agente_id_o').select2();
    $('#agente_id_d').select2();
    $('#agente_id_c').select2();
    $('#usuario_ejecutivo_id').select2();
    $('#sucursal_id').select2();
    $('#facturar_a').select2();


    tipo_cot.change(function() {
        switch (tipo_cot.val()) {
            case '1':
                consecutivo.attr('id', 'consecutivo_mn');
                consecutivo.attr('name', 'consecutivo_mn');
                break;
            case '2':
                consecutivo.attr('id', 'consecutivo_impo');
                consecutivo.attr('name', 'consecutivo_impo');
                break;
            case '3':
                consecutivo.attr('id', 'consecutivo_expo');
                consecutivo.attr('name', 'consecutivo_expo');
                break;
            default:
                consecutivo.attr('id', 'consecutivo_mn');
                consecutivo.attr('name', 'consecutivo_mn');
                consecutivo.val('');
                break;
        }
    });

    tipo_trans.change(function() {
        switch (tipo_trans.val()) {
            case '':
            case '1':
            case '3':
            case '4':
            case '5':
                cbm_a.val("");
                cbm_m.val("");
                lib_a.val("");
                lib_m.val("");
                cbm_in.css("display", "");
                cbm_a_m.css("display", "none");
                lib_in.css("display", "");
                lib_a_m.css("display", "none");
                switch (producto) {
                    case '8':
                    case '4':
                        cbm_c.css("required", false);
                        break;
                    case '1':
                    case '2':
                    case '3':
                    case '5':
                    case '6':
                    case '7':
                        cbm_c.css("required", true);
                        break;
                    default:
                        cbm_c.css("required", true);
                        break;
                }
                break;
            case '2':
                cbm_c.val("");
                lib.val("");
                cbm_in.css("display", "none");
                cbm_a_m.css("display", "");
                lib_in.css("display", "none");
                lib_a_m.css("display", "");
                switch (producto) {
                    case '8':
                    case '4':
                        cbm_a.css("required", false);
                        cbm_m.css("required", false);
                        break;
                    case '1':
                    case '2':
                    case '3':
                    case '5':
                    case '6':
                    case '7':
                        cbm_a.css("required", true);
                        cbm_m.css("required", true);
                        break;
                    default:
                        cbm_a.css("required", true);
                        cbm_m.css("required", true);
                        break;
                }
                break;
            default:
                cbm_c.val("");
                cbm_in.css("display", "");
                cbm_a_m.css("display", "none");
                lib_in.css("display", "");
                lib_a_m.css("display", "none");
                break;
        }
    });

    cbm_c.change(function() {
        if (cbm_in.is(":visible")) {
            var num = parseFloat(cbm_c.val()) * 220;
            lib.val(num.toFixed(2));
        }
    })

    cbm_m.change(function() {
        if (cbm_a_m.is(":visible")) {
            if (cbm_m.val().length != 0) {
                var num = parseFloat(cbm_m.val()) * 220;
                lib_m.val(num.toFixed(2));
            }
        }
    })

    cbm_a.change(function() {
        if (cbm_a_m.is(":visible")) {
            if (cbm_a.val().length != 0) {
                var num = parseFloat(cbm_a.val()) * 220;
                lib_a.val(num.toFixed(2));
            }
        }
    })
});