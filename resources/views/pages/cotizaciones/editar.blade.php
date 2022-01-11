@extends("theme.$theme.layout")
@section('titulo')
    Modificar Cotizacion
@endsection

@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        input[data-readonly] {
            pointer-events: none;
        }

        .main-container:before {
            background-color: rgb(162, 178, 212);
        }

        .widget-main {
            background-color: cornsilk;
        }

        .main-content {
            padding-top: 3px;
        }

        .select2-container--default .select2-selection--single {
            border: 1px solid #007888;
        }

        .input-sm {
            height: 28px;
        }

        textarea,
        input[type="text"],
        input[type="password"],
        input[type="datetime"],
        input[type="datetime-local"],
        input[type="date"],
        input[type="month"],
        input[type="time"],
        input[type="week"],
        input[type="number"],
        input[type="email"],
        input[type="url"],
        input[type="search"],
        input[type="tel"],
        input[type="color"] {
            border-radius: 4px !important;
            border: 1px solid #007888;
        }

        .btn {
            font-weight: bold;
        }

        .widget-color-orange>.widget-header {
            color: #4e4321 !important;
            border-color: #e8b10d;
            text-align: center;
            background: rgb(245, 201, 115);
        }

        .widget-color-orange>.widget-header {
            text-align: center;
            background: linear-gradient(to bottom, #fff6dc 0%, #e6ac00 100%);
        }

        h2 {
            font-size: 24px;
            font-weight: bold;
        }

        .btn-info,
        .btn-info:focus {
            background-color: #007888 !important;
            border-color: #007888;
        }

        .btn-success,
        .btn-success:focus {
            border-radius: 4px !important;
            background-color: #4c7656 !important;
            border-color: #4c7656;
            font-weight: bold;
        }

        .btn-danger,
        .btn-danger:focus {
            border-radius: 4px !important;
            background-color: #991212 !important;
            border-color: #991212;
            font-weight: bold;
        }

    </style>
@endsection

@section('scripts')
    <script src="{{ asset("assets/$theme/js/date-time/moment.js") }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
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

        $enviando = false;

        function checkSubmit() {
            if (!$enviando) {
                $enviando = true;
                return true;
            } else {
                //Si llega hasta aca significa que pulsaron 2 veces el boton submit
                alert("El formulario ya se esta enviando");
                return false;
            }
        }

        function PaisSelect_or() {
            $.ajax({
                url: "{{ url('api/paises') }}",
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    $.each(response.data, function(key, value) {
                        pais_or.append("<option value='" + value.cod + "'>" + value.pais + "</option>");
                    });
                },
                error: function() {
                    alert('Hubo un error obteniendo los Paises!');
                }
            });
        }
        PaisSelect_or();
        pais_or.change(function() {
            var paisCod = $('#cod_pais_or').val();
            ciudad_or.empty();
            if (paisCod) {
                $.ajax({
                    url: "{{ url('api/ciudades') }}",
                    type: 'GET',
                    data: {
                        cod_pais: paisCod
                    },
                    dataType: 'json',
                    success: function(response) {
                        ciudad_or.append('<option value="">--Seleccione--</option>')
                        $.each(response.data, function(key, value) {
                            ciudad_or.append("<option value='" + value.ciudad_id + "'>" + value
                                .ciudad + "</option>");
                        });
                    },
                    error: function() {
                        alert('Hubo un error obteniendo las ciudades!');
                    }
                });
            }
        });

        function PaisSelect_ds() {
            $.ajax({
                url: "{{ url('api/paises') }}",
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    $.each(response.data, function(key, value) {
                        pais_ds.append("<option value='" + value.cod + "'>" + value.pais + "</option>");
                    });
                },
                error: function() {
                    alert('Hubo un error obteniendo los Paises!');
                }
            });
        }
        PaisSelect_ds();
        pais_ds.change(function() {
            var paisCod = pais_ds.val();
            ciudad_ds.empty();
            if (paisCod) {
                $.ajax({
                    url: "{{ url('api/ciudades') }}",
                    type: 'GET',
                    data: {
                        cod_pais: paisCod
                    },
                    dataType: 'json',
                    success: function(response) {
                        ciudad_ds.append('<option value="">--Seleccione--</option>')
                        $.each(response.data, function(key, value) {
                            ciudad_ds.append("<option value='" + value.ciudad_id + "'>" + value
                                .ciudad + "</option>");
                        });
                    },
                    error: function() {
                        alert('Hubo un error obteniendo las ciudades!');
                    }
                });
            }
        });

        tipooper.change(function() {
            var oper_id = tipooper.val();
            var cliente_id = cliente.val();
            var produ = producto.val();

            if (oper_id && cliente_id && produ) {
                $.ajax({
                    url: "{{ url('api/referencia') }}",
                    type: 'GET',
                    data: {
                        toper_id: oper_id,
                        tcliente_id: cliente_id,
                        producto_id: produ
                    },
                    dataType: 'json',
                    success: function(response) {
                        $.each(response.data, function(key, value) {
                            $('#num_ref').val(value.num_ref);
                        });
                    },
                    error: function() {
                        alert('Hubo un error obteniendo las areas!');
                    }
                });
            }
            switch (oper_id) {
                case '1':
                    pais_ds.val("");
                    pais_ds.change();
                    ciudad_ds.empty();
                    ciudad_ds.append('<option value="">--Seleccione--</option>')
                    pais_ds.attr("readonly", false);
                    PaisSelect_ds();
                    pais_or.val("CO");
                    pais_or.change();
                    pais_or.attr("readonly", true);
                    break;
                case '2':
                    pais_or.val("");
                    pais_or.change();
                    ciudad_or.empty();
                    ciudad_or.append('<option value="">--Seleccione--</option>')
                    pais_or.attr("readonly", false);
                    PaisSelect_or();
                    pais_ds.val("CO");
                    pais_ds.change();
                    pais_ds.attr("readonly", true);
                    break;
                case '4':
                    pais_or.val("CO");
                    pais_or.change();
                    pais_or.attr("readonly", true);
                    pais_ds.val("CO");
                    pais_ds.change();
                    pais_ds.attr("readonly", true);
                    break;
                case '3':
                case '5':
                default:
                    pais_or.val("");
                    pais_or.change();
                    pais_or.attr("readonly", false);
                    PaisSelect_or();
                    pais_ds.val("");
                    pais_ds.change();
                    pais_ds.attr("readonly", false);
                    PaisSelect_ds();
                    ciudad_or.empty();
                    ciudad_or.append('<option value="">--Seleccione--</option>');
                    ciudad_ds.empty();
                    ciudad_ds.append('<option value="">--Seleccione--</option>');
                    break;
            }
        });

        cliente.change(function() {
            var oper_id = tipooper.val();
            var cliente_id = cliente.val();
            var produ = producto.val();
            if (oper_id && cliente_id && produ) {
                $.ajax({
                    url: "{{ url('api/referencia') }}",
                    type: 'GET',
                    data: {
                        toper_id: oper_id,
                        tcliente_id: cliente_id,
                        producto_id: produ
                    },
                    dataType: 'json',
                    success: function(response) {
                        $.each(response.data, function(key, value) {
                            $('#num_ref').val(value.num_ref);
                        });
                    },
                    error: function() {
                        alert('Hubo un error obteniendo las areas!');
                    }
                });
            }
        });

        producto.change(function() {
            var oper_id = tipooper.val();
            var cliente_id = cliente.val();
            var produ = producto.val();
            if (oper_id && cliente_id && produ) {
                $.ajax({
                    url: "{{ url('api/referencia') }}",
                    type: 'GET',
                    data: {
                        toper_id: oper_id,
                        tcliente_id: cliente_id,
                        producto_id: produ
                    },
                    dataType: 'json',
                    success: function(response) {
                        $.each(response.data, function(key, value) {
                            if (value.num_ref == null) {
                                $('#num_ref').val("#");
                            } else {
                                $('#num_ref').val(value.num_ref);
                            }
                        });
                    },
                    error: function() {
                        alert('Hubo un error obteniendo el numero de Referencia');
                    }
                });
            }
            switch (produ) {
                case '4':
                    $('#ttrans_id').find('[value=2]').remove();
                    $('#ttrans_id').find('[value=3]').remove();
                    $('#ttrans_id').find('[value=4]').remove();
                    cbm_a.val("");
                    cbm_m.val("");
                    cbm_c.val("");
                    lib.val("");
                    lib_a.val("");
                    lib_m.val("");
                    cbm_in.css("display", "");
                    cbm_a_m.css("display", "none");
                    lib_in.css("display", "");
                    lib_a_m.css("display", "none");
                    cbm_c.attr("disabled", true);
                    cbm_a.attr("disabled", true);
                    cbm_m.attr("disabled", true);
                    break;
                case '':
                case '1':
                case '2':
                case '3':
                case '5':
                case '6':
                case '7':
                    $('#ttrans_id').empty();
                    $('#ttrans_id').append('<option value="">--Seleccione--</option>')
                    $.ajax({
                        url: "{{ url('api/transporte') }}",
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            $.each(response.data, function(key, value) {
                                $('#ttrans_id').append("<option value='" + value.ttrans_id +
                                    "'>" + value.tipotransporte + "</option>");
                            });
                        },
                        error: function() {
                            alert('Hubo un error obteniendo los Transportes!');
                        }
                    });
                    cbm_c.attr("disabled", false);
                    cbm_a.attr("disabled", false);
                    cbm_m.attr("disabled", false);
                    break;
                case '8':      
	            cbm_a.val("");
                    cbm_m.val("");
                    cbm_c.val("");
                    lib.val("");
                    lib_a.val("");
                    lib_m.val("");
                    cbm_c.attr("disabled", true);
                    cbm_a.attr("disabled", true);
                    cbm_m.attr("disabled", true);
                    break;
            }
        });
    </script>
    <script src="{{ asset('assets/js/editar_cotizacion.js') }}" type="text/javascript"></script>
@endsection

@section('contenido')
    <div class="main-content">
        <div class="col-sm-12 widget-container-col" id="widget-container-col-9">
            <div class="row">
                <div class="col-xs-12 col-sm-12 widget-container-col" id="widget-container-col-3">
                    <div class="widget-box widget-color-orange" id="widget-box-3">
                        <div class="widget-header widget-header-small">
                            <h2 class="widget-title">Modificar Cotización</h2>
                            <div class="widget-toolbar">
                                <a href="{{ route('cotizaciones_mn') }}"
                                    class="btn btn-outline-secondary btn-sm btn-info btn-round">
                                    <span><i class="fa fa-fw fa-reply-all"></i> Volver al listado</span>
                                </a>
                            </div>
                        </div>
                        <div class="widget-body bg-dark">
                            <div class="widget-main black">
                                <br>
                                <form action="{{ route('actualizar_cotizacion', ['id' => $cotizacion->cot_id]) }}"
                                    id="form-general" class="form-horizontal" method="POST" autocomplete="off">
                                    @csrf @method("put")
                                    <div class="card-body">
                                        @include('pages.cotizaciones.form_editar')
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
