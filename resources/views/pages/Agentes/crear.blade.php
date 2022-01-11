@extends("theme.$theme.layout")
@section('titulo')
    Crear Agente
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

        .input-sm {
            height: 28px;
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

        .btn-warning,
        .btn-warning:focus {
            border-radius: 4px !important;
            background-color: #ccab18 !important;
            border-color: #ccab18;
            font-weight: bold;
        }

    </style>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        var pais = $('#cod_pais')
        var ciudad = $('#ciudad_id')
        var estado = $('#estado_id')
        var botonr = $('#reset')

        pais.select2();
        ciudad.select2();
        estado.select2();

        function PaisSelect() {
            $.ajax({
                url: "{{ url('api/paises') }}",
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
        PaisSelect();
        pais.change(function() {
            var paisCod = pais.val();
            ciudad.empty();
            if (paisCod) {
                $.ajax({
                    url: "{{ url('api/ciudades') }}",
                    type: 'GET',
                    data: {
                        cod_pais: paisCod
                    },
                    dataType: 'json',
                    success: function(response) {
                        ciudad.append('<option value="">--Seleccione--</option>')
                        $.each(response.data, function(key, value) {
                            ciudad.append("<option value='" + value.ciudad_id + "'>" + value
                                .ciudad + "</option>");
                        });
                    },
                    error: function() {
                        alert('Hubo un error obteniendo las ciudades!');
                    }
                });
            }
        });


        function limpiarSelects() {
            paisSelect.empty();
            paisSelect.append('<option value="">--Seleccione--</option>')
            PaisesSelect();
            ciudadSelect.empty();
            ciudadSelect.append('<option value="">--Seleccione--</option>')
        }

        botonr.click(function() { // apply to reset button's click event
            limpiarSelects();
        });
    </script>
@endsection

@section('contenido')
    <div class="main-content">
        <div class="col-sm-12 widget-container-col" id="widget-container-col-9">
            <div class="row">
                <div class="col-xs-12 col-sm-12 widget-container-col" id="widget-container-col-3">
                    <div class="widget-box widget-color-orange" id="widget-box-3">
                        <div class="widget-header widget-header-small">
                            <h2 class="widget-title">Nuevo Agente</h2>
                            <div class="widget-toolbar">
                                <a href="{{ route('agentes') }}"
                                    class="btn btn-outline-secondary btn-sm btn-info btn-round">
                                    <span><i class="fa fa-fw fa-reply-all"></i> Volver al listado</span>
                                </a>
                            </div>
                        </div>
                        <div class="widget-body">
                            <div class="widget-main">
                                <br>
                                <div class="card card-info">
                                    <form action="{{ route('guardar_agente') }}" id="form-general"
                                        class="form-horizontal form--label-right" method="POST" autocomplete="off">
                                        @csrf
                                        <div class="card-body">
                                            @include('pages.Agentes.form_crear')
                                        </div>
                                    </form>
                                </div>
                                <!-- /section:custom/file-input.filter -->
                            </div>
                        </div>
                    </div>
                    @include('includes.form-error')
                    @include('includes.mensaje')
                </div>
            </div>
        </div>
    </div>
@endsection
