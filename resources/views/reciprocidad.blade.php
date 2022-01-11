@extends("theme.$theme.layout")
@section('titulo')
    Reciprocidad
@endsection

@if (Auth::check())
    @section('styles')
        <link href="{{ asset('assets/js/jquery-nestable/jquery.nestable.css') }}" rel="stylesheet" type="text/css" />
        <link rel="stylesheet"
            href="{{ asset('assets/js/datatables/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet"
            href="{{ asset('assets/js/datatables/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
        <link rel="stylesheet"
            href="{{ asset('assets/js/datatables/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <style>
            .av {
                background: linear-gradient(to bottom, #82af6f 0%, #2e4c21 100%);
                color: rgb(255, 255, 255);
            }

            .table-bordered>thead>tr>th,
            .table-bordered>tbody>tr>th,
            .table-bordered>tfoot>tr>th,
            .table-bordered>thead>tr>td,
            .table-bordered>tbody>tr>td,
            .table-bordered>tfoot>tr>td {
                border: 1px solid #000000;
            }

            .second_av {
                background-color: rgb(134, 204, 107, 57%);
                color: rgb(0, 0, 0);
                font-weight: bold;
            }

            .ag {
                background: linear-gradient(to bottom, #307ecc 0%, #163350 100%);
                color: rgb(255, 255, 255);
            }

            .second_ag {
                background-color: rgb(72, 165, 255, 57%);
                color: rgb(0, 0, 0);
                font-weight: bold;
            }

            .dataTable>thead>tr>th.sorting_desc,
            .dataTable>thead>tr>th.sorting_asc {
                background-image: -webkit-linear-gradient(top, #274e7e 0%, #e3e7ed 100%);
                background-image: -o-linear-gradient(top, #1a385e 0%, #1a385e 100%);
                background-image: linear-gradient(to bottom, #0aa4b8c4 0%, #ffffffa8 100%);
                background-repeat: repeat-x;
                filter: progid: DXImageTransform.Microsoft.gradient(startColorstr='#ffeff3f8', endColorstr='#ffe3e7ed', GradientType=0);
            }

            .agente {
                background-color: rgb(116, 116, 116);
                color: white;
                font-weight: bold;
            }

            .dataTables_info {
                font-size: 14px;
                text-align: right;
                font-weight: bold;
            }

            .dataTables_scrollBody::-webkit-scrollbar-track {
                -webkit-box-shadow: inset 0 0 6px rgb(82, 82, 82);
                background-color: #F5F5F5;
                border-radius: 10px;
            }

            .dataTables_scrollBody::-webkit-scrollbar {
                width: 6px;
                background-color: #F5F5F5;
            }

            .dataTables_scrollBody::-webkit-scrollbar-thumb {
                background-color: rgb(82, 82, 82);
                border-radius: 10px;
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

            table.dataTable>thead .sorting:before,
            table.dataTable>thead .sorting_asc:before,
            table.dataTable>thead .sorting_desc:before,
            table.dataTable>thead .sorting_asc_disabled:before,
            table.dataTable>thead .sorting_desc_disabled:before {
                right: 1em;
                content: "";
            }

            .table {
                width: 100%;
                border-collapse: collapse;
            }

            .table td {
                padding: 7px;
                border: #000000 1px solid;
            }

            /* Define the default color for all the table rows */
            .table tr {
                background: #ffffff;
            }

            .table-hover tbody tr:hover td,
            .table-hover tbody tr:hover th {
                background-color: rgb(221, 164, 77);
                font-weight: bold;
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

            h2 {
                font-weight: bold;
            }

            .widget-color-orange>.widget-header {
                text-align: center;
                background: linear-gradient(to bottom, #fff6dc 0%, #e6ac00 100%);
            }

            table.dataTable>thead .sorting:before,
            table.dataTable>thead .sorting:after,
            table.dataTable>thead .sorting_asc:before,
            table.dataTable>thead .sorting_asc:after,
            table.dataTable>thead .sorting_desc:before,
            table.dataTable>thead .sorting_desc:after,
            table.dataTable>thead .sorting_asc_disabled:before,
            table.dataTable>thead .sorting_asc_disabled:after,
            table.dataTable>thead .sorting_desc_disabled:before,
            table.dataTable>thead .sorting_desc_disabled:after {
                opacity: 1;
            }


            .dataTable>thead>tr>th.sorting_asc:after {
                content: "\f0de";
                top: 4px;
                color: #ffffff;
            }

            .dataTable>thead>tr>th.sorting_desc:after {
                content: "\f0dd";
                top: -6px;
                color: #ffffff;
            }

        </style>
    @endsection

    @section('scriptsPlugins')
        <script src="{{ asset('assets/js/jquery-nestable/jquery.nestable.js') }}" type="text/javascript"></script>
    @endsection

    @section('scripts')
        <script src="{{ asset('assets/js/datatables/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/js/datatables/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('assets/js/datatables/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('assets/js/datatables/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('assets/js/datatables/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('assets/js/datatables/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('assets/js/datatables/jszip/jszip.min.js') }}"></script>
        <script src="{{ asset('assets/js/datatables/pdfmake/pdfmake.min.js') }}"></script>
        <script src="{{ asset('assets/js/datatables/pdfmake/vfs_fonts.js') }}"></script>
        <script src="{{ asset('assets/js/datatables/datatables-buttons/js/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('assets/js/datatables/datatables-buttons/js/buttons.print.min.js') }}"></script>
        <script src="{{ asset('assets/js/datatables/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
        <script src="{{ asset("assets/$theme/js/date-time/moment.js") }}"></script>
        <script src="//cdn.datatables.net/plug-ins/1.10.25/dataRender/datetime.js"></script>
        <script>
            var tabla_rec = $('#reciprocidad').DataTable({
                paging: false,
                dom: "<'col-xs-12't>" + "<'col-xs-12 col-sm-8'l>" +
                    "<'col-xs-12 col-sm-4'i>",
                lengthChange: false,
                ordering: true,
                info: true,
                scrollY: "340px",
                responsive: true,
                serverSide: false,
                ajax: {
                    url: "{{ url('api/reciprocidad') }}",
                    type: 'GET',
                    dataType: 'json',
                },
                columns: [{
                        data: "Agente",
                        "sClass": "left agente",
                    },
                    {
                        data: "GANADAS_AV",
                        "sClass": "center second_av"
                    },
                    {
                        data: "PERDIDAS_AV",
                        "sClass": "center second_av"
                    },
                    {
                        data: "PENDIENTES_AV",
                        "sClass": "center second_av"
                    },
                    {
                        data: "TOTAL_AV",
                        "sClass": "center second_av"
                    },
                    {
                        data: "GANADAS_AG",
                        "sClass": "center second_ag"
                    },
                    {
                        data: "PERDIDAS_AG",
                        "sClass": "center second_ag"
                    },
                    {
                        data: "PENDIENTES_AG",
                        "sClass": "center second_ag"
                    },
                    {
                        data: "TOTAL_AG",
                        "sClass": "center second_ag"
                    }
                ],
            });
            tabla_rec.buttons().container().appendTo($('.tableTools-container'));
            $(document).ready(function() {
                $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre',
                    'Octubre',
                    'Noviembre', 'Diciembre'
                ]
                for (let index = 0; index < new Date().getMonth() + 1; index++) {
                    $('#mes').append("<option value='" + (index + 1) + "'>" + $meses[index] + "</option>");
                }
                $('#agente').select2();
                $('#operacion').select2();
                $('#producto').select2();
                $('#mes').select2();
            });
        </script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $('#agente').on('change', function() {
                if ($('#agente option:selected').val() == '') {
                    tabla_rec
                        .columns(0)
                        .search("")
                        .draw();
                } else {
                    tabla_rec
                        .columns(0)
                        .search($('#agente option:selected').val())
                        .draw();
                }
            });

            $('#producto').on('change', function() {
                tabla_rec.destroy();
                tabla_rec = $('#reciprocidad').DataTable({
                    serverSide: false,
                    ajax: {
                        url: "{{ url('api/reciprocidad') }}",
                        type: 'GET',
                        data: {
                            "producto": $('#producto').val(),
                            "operacion": $('#operacion').val(),
                            "mes": $('#mes').val(),
                        },
                        dataType: 'json',
                    },
                    columns: [{
                            data: "Agente",
                            "sClass": "left agente",
                        },
                        {
                            data: "GANADAS_AG",
                            "sClass": "center second_av"
                        },
                        {
                            data: "PERDIDAS_AG",
                            "sClass": "center second_av"
                        },
                        {
                            data: "PENDIENTES_AG",
                            "sClass": "center second_av"
                        },
                        {
                            data: "TOTAL_AG",
                            "sClass": "center second_av"
                        },
                        {
                            data: "GANADAS_AV",
                            "sClass": "center second_ag"
                        },
                        {
                            data: "PERDIDAS_AV",
                            "sClass": "center second_ag"
                        },
                        {
                            data: "PENDIENTES_AV",
                            "sClass": "center second_ag"
                        },
                        {
                            data: "TOTAL_AV",
                            "sClass": "center second_ag"
                        },
                    ],
                    paging: false,
                    dom: "<'col-xs-12't>" + "<'col-xs-12 col-sm-8'l>" +
                        "<'col-xs-12 col-sm-4'i>",
                    lengthChange: false,
                    ordering: true,
                    info: true,
                    scrollY: "340px",
                    responsive: true,
                });
            });

            $('#operacion').on('change', function() {
                tabla_rec.destroy();
                tabla_rec = $('#reciprocidad').DataTable({
                    serverSide: false,
                    ajax: {
                        url: "{{ url('api/reciprocidad') }}",
                        type: 'GET',
                        data: {
                            "producto": $('#producto').val(),
                            "operacion": $('#operacion').val(),
                            "mes": $('#mes').val(),
                        },
                        dataType: 'json',
                    },
                    columns: [{
                            data: "Agente",
                            "sClass": "left agente",
                        },
                        {
                            data: "GANADAS_AG",
                            "sClass": "center second_av"
                        },
                        {
                            data: "PERDIDAS_AG",
                            "sClass": "center second_av"
                        },
                        {
                            data: "PENDIENTES_AG",
                            "sClass": "center second_av"
                        },
                        {
                            data: "TOTAL_AG",
                            "sClass": "center second_av"
                        },
                        {
                            data: "GANADAS_AV",
                            "sClass": "center second_ag"
                        },
                        {
                            data: "PERDIDAS_AV",
                            "sClass": "center second_ag"
                        },
                        {
                            data: "PENDIENTES_AV",
                            "sClass": "center second_ag"
                        },
                        {
                            data: "TOTAL_AV",
                            "sClass": "center second_ag"
                        },
                    ],
                    paging: false,
                    dom: "<'col-xs-12't>" + "<'col-xs-12 col-sm-8'l>" +
                        "<'col-xs-12 col-sm-4'i>",
                    lengthChange: false,
                    ordering: true,
                    info: true,
                    scrollY: "370px",
                    responsive: true,
                });
            });

            

            $('#mes').on('change', function() {
                tabla_rec.destroy();
                tabla_rec = $('#reciprocidad').DataTable({
                    serverSide: false,
                    ajax: {
                        url: "{{ url('api/reciprocidad') }}",
                        type: 'GET',
                        data: {
                            "producto": $('#producto').val(),
                            "operacion": $('#operacion').val(),
                            "mes": $('#mes').val(),
                        },
                        dataType: 'json',
                    },
                    columns: [{
                            data: "Agente",
                            "sClass": "left agente",
                        },
                        {
                            data: "GANADAS_AG",
                            "sClass": "center second_av"
                        },
                        {
                            data: "PERDIDAS_AG",
                            "sClass": "center second_av"
                        },
                        {
                            data: "PENDIENTES_AG",
                            "sClass": "center second_av"
                        },
                        {
                            data: "TOTAL_AG",
                            "sClass": "center second_av"
                        },
                        {
                            data: "GANADAS_AV",
                            "sClass": "center second_ag"
                        },
                        {
                            data: "PERDIDAS_AV",
                            "sClass": "center second_ag"
                        },
                        {
                            data: "PENDIENTES_AV",
                            "sClass": "center second_ag"
                        },
                        {
                            data: "TOTAL_AV",
                            "sClass": "center second_ag"
                        },
                    ],
                    paging: false,
                    dom: "<'col-xs-12't>" + "<'col-xs-12 col-sm-8'l>" +
                        "<'col-xs-12 col-sm-4'i>",
                    lengthChange: false,
                    ordering: true,
                    info: true,
                    scrollY: "370px",
                    responsive: true,
                });
            });
        </script>
    @endsection
@endif

@section('contenido')
    <div class="main-content">
        <div class="col-sm-12 widget-container-col" id="widget-container-col-9">
            <div class="row">
                <div class="col-xs-12 col-sm-12 widget-container-col" id="widget-container-col-3">
                    <div class="widget-box widget-color-orange" id="widget-box-3">
                        <!-- #section:custom/widget-box.options.collapsed -->
                        <div class="widget-header widget-header-small">
                            <h3 class="widget-title">
                                <strong>Reciprocidad con los Agentes</strong>
                            </h3>
                            <div class="widget-toolbar">
                                <div id="tableTools-container" name="tableTools-container"></div>
                            </div>
                        </div>
                        <!-- /section:custom/widget-box.options.collapsed -->
                        <div class="widget-body">
                            <div class="widget-main">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label"><b>Agente</b></label>
                                            <div class="col-sm-10">
                                                <select class="form-control input-sm" style="width: 100%;" id="agente"
                                                    name="agente" required>
                                                    <option value="">---</option>
                                                    @foreach ($agentes as $agente)
                                                        <option value="{{ $agente->razon_social }}">
                                                            {{ $agente->razon_social }} | {{ $agente->codigo }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label"><b>Operación</b></label>
                                            <div class="col-sm-8">
                                                <select class="form-control input-sm" style="width: 100%;" id="operacion"
                                                    name="operacion" required>
                                                    <option value="">---</option>
                                                    <option value="1">Exportación</option>
                                                    <option value="2">Importación</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label"><b>Producto</b></label>
                                            <div class="col-sm-9">
                                                <select class="form-control input-sm" style="width: 100%;" id="producto"
                                                    name="producto" required>
                                                    <option value="">---</option>
                                                    @foreach ($productos as $producto)
                                                        <option value="{{ $producto->producto }}">
                                                            {{ $producto->producto }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label"><b>Mes</b></label>
                                            <div class="col-sm-9">
                                                <select class="form-control input-sm" style="width: 100%;" id="mes"
                                                    name="mes" required>
                                                    <option value="">---</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <table id="reciprocidad" class="table table-sm table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th class="center"
                                                    style="background: linear-gradient(to bottom, #7c7c7c 0%, #000000 100%);;
                                                                                color: rgb(255, 255, 255); font-size: 18px;" rowspan="2">
                                                    Agente
                                                </th>
                                                <th class="center av" colspan="4">Embarques Controlados
                                                    Aviomar
                                                </th>
                                                <th class="center ag" colspan="4">Embarques Controlados Agente</th>
                                            </tr>
                                            <tr>
                                                <th class="center"
                                                    style="background: linear-gradient(to bottom, #82af6f 0%, #2e4c21 100%);color: rgb(255, 255, 255)">
                                                    Ganadas
                                                </th>
                                                <th class="center"
                                                    style="background: linear-gradient(to bottom, #82af6f 0%, #2e4c21 100%);color: rgb(255, 255, 255)">
                                                    Perdidas
                                                </th>
                                                <th class="center"
                                                    style="background: linear-gradient(to bottom, #82af6f 0%, #2e4c21 100%);color: rgb(255, 255, 255)">
                                                    Pendientes
                                                </th>
                                                <th class="center"
                                                    style="background: linear-gradient(to bottom, #82af6f 0%, #2e4c21 100%);color: rgb(255, 255, 255)">
                                                    Total
                                                </th>
                                                <th class="center"
                                                    style="background: linear-gradient(to bottom, #307ecc 0%, #163350 100%);color: rgb(255, 255, 255);">
                                                    Ganadas
                                                </th>
                                                <th class="center"
                                                    style="background: linear-gradient(to bottom, #307ecc 0%, #163350 100%);color: rgb(255, 255, 255);">
                                                    Perdidas
                                                </th>
                                                <th class="center"
                                                    style="background: linear-gradient(to bottom, #307ecc 0%, #163350 100%);color: rgb(255, 255, 255);">
                                                    Pendientes
                                                </th>
                                                <th class="center"
                                                    style="background: linear-gradient(to bottom, #307ecc 0%, #163350 100%);color: rgb(255, 255, 255);">
                                                    Total
                                                </th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
