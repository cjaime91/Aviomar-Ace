@extends("theme.$theme.layout")
@section('titulo')
    Reportes
@endsection

@if (Auth::check())
    @section('styles')
        <link href="{{ asset('assets/js/jquery-nestable/jquery.nestable.css') }}" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="{{ asset("assets/$theme/css/ace.css") }}" class="ace-main-stylesheet"
            id="main-ace-style" />
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <style>
            .main-container:before {
                background-color: rgb(162, 178, 212);
            }

            .main-content {
                padding-top: 3px;
            }

            .widget-main {
                background: papayawhip;
            }

            .widget-color-blue>.widget-header {
                background-image: linear-gradient(to bottom, #307ecc 0%, #163350 100%);
            }

            .widget-color-green>.widget-header {
                background-image: linear-gradient(to bottom, #82af6f 0%, #2e4c21 100%);
            }

            h6 {
                font-size: 16px;
                font-weight: bold;
            }

            .col-sm-1 {
                width: 10.333333%;
            }

            .btn-success,
            .btn-success:focus {
                border-radius: 4px !important;
                background-color: #4c7656 !important;
                border-color: #4c7656;
                font-weight: bold;
            }

        </style>
    @endsection

    @section('scriptsPlugins')
        <script src="{{ asset('assets/js/jquery-nestable/jquery.nestable.js') }}" type="text/javascript"></script>
    @endsection

    @section('scripts')
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="{{ asset("assets/$theme/js/date-time/moment.js") }}"></script>
        <script>
            $('#mercado').select2();
            $('#mes1').select2();
            $('#agente').select2();
            $('#operacion').select2();
            $('#mes2').select2();
            $('#negocio').select2();
            $('#anio1').select2();
            $('#anio2').select2();
            var anio = moment().format("YYYY");

            $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre',
                'Octubre', 'Noviembre', 'Diciembre'
            ]
            $('#mercado').change(function() {
                $ct = $('#mercado').val();
                $mes1 = $('#mes1').val();
                $anio_1 = $('#anio1').val();
                if ($anio_1 == '') {
                    $anio_1 = 0;
                }
                /*$('#DescargaM').attr('action', "http://aviomar-ace.test/pages/reports/exportar_reporte/" + $ct + "/" +
                    $mes1 + "/" + $anio_1);*/
                $('#DescargaM').attr('action',
                    "http://186.29.91.156/Aviomar-Ace/public/pages/reports/exportar_reporte/" + $ct + "/" + $mes1 +
                    "/" + $anio_1);
            });
            $('#mes1').change(function() {
                $mes1 = $('#mes1').val();
                $ct = $('#mercado').val();
                $anio_1 = $('#anio1').val();
                if ($anio_1 == '') {
                    $anio_1 = 0;
                }
                /*$('#DescargaM').attr('action', "http://aviomar-ace.test/pages/reports/exportar_reporte/" + $ct + "/" +
                    $mes1 + "/" + $anio_1);*/
                $('#DescargaM').attr('action',
                    "http://186.29.91.156/Aviomar-Ace/public/pages/reports/exportar_reporte/" + $ct + "/" + $mes1 +
                    "/" + $anio_1);
            });

            $('#anio1').change(function() {
                $mes1 = $('#mes1').val();
                $ct = $('#mercado').val();
                $anio_1 = $('#anio1').val();
                $('#mes1').empty();
                $('#mes1').append('<option value="0">---</option>')
                if ($anio_1 >= anio) {
                    for (let index = 0; index < new Date().getMonth() + 1; index++) {
                        $('#mes1').append("<option value='" + (index + 1) + "'>" + $meses[index] + "</option>");
                    }
                } else {
                    for (let index = 0; index < 12; index++) {
                        $('#mes1').append("<option value='" + (index + 1) + "'>" + $meses[index] + "</option>");
                    }
                }
                /*$('#DescargaM').attr('action', "http://aviomar-ace.test/pages/reports/exportar_reporte/" + $ct + "/" +
                    $mes1 + "/" + $anio_1);*/

                $('#DescargaM').attr('action',
                    "http://186.29.91.156/Aviomar-Ace/public/pages/reports/exportar_reporte/" + $ct + "/" + $mes1 +
                    "/" + $anio_1);
            });


            $('#agente').change(function() {
                $agente = $('#agente').val();
                $operacion = $('#operacion').val();
                $mes2 = $('#mes2').val();
                $producto = $('#negocio').val();
                $anio_2 = $('#anio2').val();
                if ($anio_2 == '') {
                    $anio_2 = 0;
                }
                /*$('#DescargaR').attr('action', "http://aviomar-ace.test/pages/reports/exportar_reporte_rec/" + $agente +
                    "/" + $operacion + "/" + $mes2 + "/" + $producto + "/" + $anio_2);*/
                $('#DescargaR').attr('action',
                    "http://186.29.91.156/Aviomar-Ace/public/pages/reports/exportar_reporte_rec/" + $agente + "/" +
                    $operacion + "/" + $mes2 + "/" + $producto + "/" + $anio_2);
            });
            $('#operacion').change(function() {
                $agente = $('#agente').val();
                $operacion = $('#operacion').val();
                $mes2 = $('#mes2').val();
                $producto = $('#negocio').val();
                $anio_2 = $('#anio2').val();
                if ($anio_2 == '') {
                    $anio_2 = 0;
                }
                /*$('#DescargaR').attr('action', "http://aviomar-ace.test/pages/reports/exportar_reporte_rec/" + $agente +
                    "/" + $operacion + "/" + $mes2 + "/" + $producto + "/" + $anio_2);*/
                $('#DescargaR').attr('action',
                    "http://186.29.91.156/Aviomar-Ace/public/pages/reports/exportar_reporte_rec/" + $agente + "/" +
                    $operacion + "/" + $mes2 + "/" + $producto + "/" + $anio_2);
            });

            $('#mes2').change(function() {
                $agente = $('#agente').val();
                $operacion = $('#operacion').val();
                $mes2 = $('#mes2').val();
                $producto = $('#negocio').val();
                $anio_2 = $('#anio2').val();
                if ($anio_2 == '') {
                    $anio_2 = 0;
                }
                /*$('#DescargaR').attr('action', "http://aviomar-ace.test/pages/reports/exportar_reporte_rec/" + $agente +
                    "/" + $operacion + "/" + $mes2 + "/" + $producto + "/" + $anio_2);*/
                $('#DescargaR').attr('action',
                    "http://186.29.91.156/Aviomar-Ace/public/pages/reports/exportar_reporte_rec/" + $agente + "/" +
                    $operacion + "/" + $mes2 + "/" + $producto + "/" + $anio_2);
            });
            $('#negocio').change(function() {
                $agente = $('#agente').val();
                $operacion = $('#operacion').val();
                $mes2 = $('#mes2').val();
                $producto = $('#negocio').val();
                $anio_2 = $('#anio2').val();
                if ($anio_2 == '') {
                    $anio_2 = 0;
                }
                /*$('#DescargaR').attr('action', "http://aviomar-ace.test/pages/reports/exportar_reporte_rec/" + $agente +
                    "/" + $operacion + "/" + $mes2 + "/" + $producto + "/" + $anio_2);*/
                $('#DescargaR').attr('action',
                    "http://186.29.91.156/Aviomar-Ace/public/pages/reports/exportar_reporte_rec/" + $agente + "/" +
                    $operacion + "/" + $mes2 + "/" + $producto + "/" + $anio_2);
            });


            $('#anio2').change(function() {
                $agente = $('#agente').val();
                $operacion = $('#operacion').val();
                $mes2 = $('#mes2').val();
                $producto = $('#negocio').val();
                $anio_2 = $('#anio2').val();
                if ($anio_2 == '') {
                    $anio_2 = 0;
                }
                $('#mes2').empty();
                $('#mes2').append('<option value="0">---</option>')
                if ($anio_2 >= anio) {
                    for (let index = 0; index < new Date().getMonth() + 1; index++) {
                        $('#mes2').append("<option value='" + (index + 1) + "'>" + $meses[index] + "</option>");
                    }
                } else {
                    for (let index = 0; index < 12; index++) {
                        $('#mes2').append("<option value='" + (index + 1) + "'>" + $meses[index] + "</option>");
                    }
                }
                /*$('#DescargaR').attr('action', "http://aviomar-ace.test/pages/reports/exportar_reporte_rec/" + $agente +
                    "/" + $operacion + "/" + $mes2 + "/" + $producto + "/" + $anio_2);*/
                $('#DescargaR').attr('action',
                    "http://186.29.91.156/Aviomar-Ace/public/pages/reports/exportar_reporte_rec/" + $agente + "/" +
                    $operacion + "/" + $mes2 + "/" + $producto + "/" + $anio_2);
            });
        </script>
    @endsection
@endif

@section('contenido')
    <div class="main-content">
        <div class="widget-body">
            <div class="col-sm-4 widget-container-col" id="widget-container-col-3">
                <div class="widget-box widget-color-green" id="widget-box-3">
                    <!-- #section:custom/widget-box.options.collapsed -->
                    <div class="widget-header widget-header-small">
                        <h6 class="widget-title">
                            Reporte Menaje
                        </h6>

                        <div class="widget-toolbar">

                            <a href="#" data-action="collapse">
                                <i class="ace-icon fa fa-minus" data-icon-show="fa-plus" data-icon-hide="fa-minus"></i>
                            </a>
                        </div>
                    </div>

                    <!-- /section:custom/widget-box.options.collapsed -->
                    <div class="widget-body">
                        <div class="widget-main">
                            <div class="content">
                                <form action="{{ route('exportar_reporte', ['ct' => '0', 'mes' => '0', 'anio' => '0']) }}"
                                    id="DescargaM">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label class=""><b>Año</b></label>
                                            <select class="input-sm" style="width: 100%;" id="anio1" name="anio1"
                                                required>
                                                <option value="">---</option>
                                                <option value="2021">2021</option>
                                                <option value="2022">2022</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-6">
                                            <label class=""><b>Mes</b></label>
                                            <select class="input-sm" style="width: 100%;" id="mes1" name="mes1">
                                                <option value="0">---</option>
                                            </select>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label class=""><b>Tipo Cotización</b></label>
                                            <select class="input-sm" style="width: 100%;" id="mercado" name="mercado">
                                                <option value="0">---</option>
                                                <option value="consecutivo_mn">Mercado Natural</option>
                                                <option value="consecutivo_expo">Agente Exportación</option>
                                                <option value="consecutivo_impo">Agente Importación</option>
                                            </select>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <button type="submit" class="col-sm-12 btn btn-sm btn-success btn-round">
                                                <i class="ace-icon fa fa-check"></i>
                                                <b>Descargar</b>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-5 widget-container-col" id="widget-container-col-3">
                <div class="widget-box widget-color-blue" id="widget-box-3">
                    <!-- #section:custom/widget-box.options.collapsed -->
                    <div class="widget-header widget-header-small">
                        <h6 class="widget-title">
                            Reporte Reciprocidad
                        </h6>

                        <div class="widget-toolbar">

                            <a href="#" data-action="collapse">
                                <i class="ace-icon fa fa-minus" data-icon-show="fa-plus" data-icon-hide="fa-minus"></i>
                            </a>
                        </div>
                    </div>

                    <!-- /section:custom/widget-box.options.collapsed -->
                    <div class="widget-body">
                        <div class="widget-main">
                            <div class="content">
                                <form
                                    action="{{ route('exportar_reporte_rec', ['agente' => '0', 'operacion' => '0', 'mes' => '0', 'producto' => '0', 'anio' => '0']) }}"
                                    id="DescargaR">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label class=""><b>Año</b></label>
                                            <select class="form-control input-sm" style="width: 100%;" id="anio2"
                                                name="anio2" required>
                                                <option value="">---</option>
                                                <option value="2021">2021</option>
                                                <option value="2022">2022</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-6">
                                            <label class=""><b>Mes</b></label>
                                            <select class="form-control input-sm" style="width: 100%;" id="mes2" name="mes2"
                                                required>
                                                <option value="0">---</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row" style="display:none">
                                        <br>
                                        <div class="col-sm-12">
                                            <label class=""><b>Agente</b></label>
                                            <select class="input-sm" style="width: 100%;" id="agente" name="agente">
                                                <option value="0">---</option>
                                                @foreach ($ag as $agente)
                                                    <option value="{{ $agente->agente_id }}">
                                                        {{ $agente->razon_social }}
                                                        ({{ $agente->ciudad }},
                                                        {{ $agente->pais }}) | {{ $agente->codigo }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label class=""><b>Operación</b></label>
                                            <select class="form-control input-sm" style="width: 100%;" id="operacion"
                                                name="operacion" required>
                                                <option value="0">---</option>
                                                <option value="1">Exportación</option>
                                                <option value="2">Importación</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-6">
                                            <label class=""><b>Negocio</b></label>
                                            <select class="form-control input-sm" style="width: 100%;" id="negocio"
                                                name="negocio" required>
                                                <option value="0">---</option>
                                                @foreach ($productos as $pr)
                                                    <option value="{{ $pr->producto }}">{{ $pr->producto }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <button type="submit" class="col-sm-12 btn btn-sm btn-success btn-round">
                                                <i class="ace-icon fa fa-check"></i>
                                                <b>Descargar</b>
                                            </button>
                                        </div>
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
