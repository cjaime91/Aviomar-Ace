@extends("theme.$theme.layout")
@section('titulo')
    Agentes
@endsection

@section('styles')
    <link href="{{ asset('assets/js/jquery-nestable/jquery.nestable.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/js/datatables/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/js/datatables/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/datatables/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/css/estilos_agentes.css') }}">
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
    <script src="{{ asset('assets/js/data_agentes.js') }}" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        var tabla_agentes1 = $('#tabla_agentes').DataTable({
            ordering: true,
            buttons: [{
                    "extend": "copy",
                    "text": "<i class='fa fa-copy bigger-110 pink'></i> <span class='hidden'>Copy to clipboard</span>",
                    "className": "btn btn-white btn-primary btn-bold"
                },
                {
                    "extend": "excel",
                    "text": "<i class='fa fa-file-excel-o bigger-110 green'></i> <span class='hidden'>Export to Excel</span>",
                    "className": "btn btn-white btn-primary btn-bold"
                },
                {
                    "extend": "pdf",
                    "text": "<i class='fa fa-file-pdf-o bigger-110 red'></i> <span class='hidden'>Export to PDF</span>",
                    "className": "btn btn-white btn-primary btn-bold"
                }
            ],
            dom: "<'col-xs-12 col-sm-2'l><'col-xs-12 col-sm-2'B><'col-xs-12 col-sm-3'i><'col-xs-12 col-sm-5'p>" +
                "<'col-xs-12't>",
            lengthChange: true,
            lengthMenu: [
                [8, 10, 25, 50, 100, -1],
                [8, 10, 25, 50, 100, "All"]
            ],
            scrollY: "300px",
            serverSide: true,
            ajax: "{{ url('api/agentes') }}",
            columns: [{
                    data: "agente_id",
                    "sClass": "center"
                },
                {
                    data: "codigo",
                    "sClass": "center"
                },
                {
                    data: "razon_social"
                },
                {
                    data: "pais",
                    "sClass": "center"
                },
                {
                    data: "ciudad",
                    "sClass": "center"
                },
                {
                    data: "estado",
                    "sClass": "center"
                },
                {
                    class: "details-control",
                    orderable: false,
                    data: null,
                    defaultContent: '<td>' +
                        '<div class="action-buttons center">' +
                        '<a href="#" role="button" class="blue" data-toggle="modal" id="enlace">' +
                        '<i class="ace-icon fa fa-pencil align-top bigger-120 icon-on-right"></i>' +
                        '</a>' +
                        '</div>' +
                        '</td>',
                },
            ],
        });
        $('#tabla_agentes tbody').on('click', 'td.details-control', function() {
            var tr = $(this).closest('tr');
            var row = tabla_agentes1.row(tr);
            var id = row.data().agente_id;
            var enlace = "http://186.29.91.156/Aviomar-Ace/public/pages/agentes/" + id + "/editar";
            //var enlace = "http://Aviomar-Ace.test/pages/agentes/" + id + "/editar";
            window.location = enlace;
        });
        $('#agente').select2();
        $('#estado').select2();
    </script>
@endsection



@section('contenido')
    <div class="main-content">
        <div class="col-sm-12 widget-container-col" id="widget-container-col-9">
            <div class="row">
                <div class="col-xs-12 col-sm-12 widget-container-col" id="widget-container-col-3">
                    <div class="widget-box widget-color-orange" id="widget-box-3">
                        <div class="widget-header widget-header-small">
                            <h2 class="widget-title">Agentes</h2>
                            @if (auth()->user()->rol_id == 2 || auth()->user()->rol_id == 1)
                                <div class="widget-toolbar">
                                    <a href="{{ route('crear_agente') }}"
                                        class="btn btn-outline-secondary btn-sm btn-info btn-round table-responsive">
                                        <i class="fa fa-fw fa-plus-circle"></i> Crear Agente
                                    </a>
                                </div>
                            @endif
                        </div>
                        <div class="widget-body">
                            <div class="widget-main">
                                <div class="row">
                                    <div class="center tableTools-container1">
                                    </div>
                                    <br>
                                    <table id="tabla_agentes" class="table table-sm text-nowrap table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th
                                                    style="background: linear-gradient(to bottom, #82af6f 0%, #2e4c21 100%);color: rgb(255, 255, 255);">
                                                    #</th>
                                                <th
                                                    style="background: linear-gradient(to bottom, #82af6f 0%, #2e4c21 100%);color: rgb(255, 255, 255);">
                                                    Codigo</th>
                                                <th
                                                    style="background: linear-gradient(to bottom, #82af6f 0%, #2e4c21 100%);color: rgb(255, 255, 255);text-align: center;">
                                                    Razon Social</th>
                                                <th
                                                    style="background: linear-gradient(to bottom, #82af6f 0%, #2e4c21 100%);color: rgb(255, 255, 255);">
                                                    Pais</th>
                                                <th
                                                    style="background: linear-gradient(to bottom, #82af6f 0%, #2e4c21 100%);color: rgb(255, 255, 255);">
                                                    Ciudad</th>
                                                <th
                                                    style="background: linear-gradient(to bottom, #82af6f 0%, #2e4c21 100%);color: rgb(255, 255, 255);">
                                                    Estado</th>
                                                <th
                                                    style="background: linear-gradient(to bottom, #82af6f 0%, #2e4c21 100%);color: rgb(255, 255, 255);">
                                                </th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div id="col-sm-12" class="widget-filtros">
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label for="form-control"><b>Codigo</b></label>
                                                <input type="text" class="form-control input-sm text-center" id="codigo"
                                                    name="codigo">
                                            </div>
                                        </div>
                                        <div class="col-sm-5">
                                            <div class="form-group">
                                                <label for="form-control"><b>Agente</b></label>
                                                <div>
                                                    <select class="form-control input-sm" style="width: 100%;" id="agente"
                                                        name="agente">
                                                        <option value="">---</option>
                                                        @foreach ($agentes as $agente)
                                                            <option value="{{ $agente->razon_social }}">
                                                                {{ $agente->razon_social }} ({{ $agente->ciudad }},
                                                                {{ $agente->pais }}) | {{ $agente->codigo }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label for="form-control"><b>Estado</b></label>
                                                <div>
                                                    <select class="form-control input-sm" style="width: 100%;" id="estado"
                                                        name="estado">
                                                        <option value="">---</option>
                                                        <option value="Activo">Activo</option>
                                                        <option value="Inactivo">Inactivo</option>
                                                        <option value="Temporal">Temporal</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
