@extends("theme.$theme.layout")
@section('titulo')
    Cotizaciones Mercado Natural
@endsection

@section('styles')
    <link href="{{ asset('assets/js/jquery-nestable/jquery.nestable.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/js/datatables/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/js/datatables/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/datatables/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/css/estilos_cotizaciones.css') }}">
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
    <script src="{{ asset('assets/js/data_cotizacion_mn.js') }}" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        var tabla_mn = $('#tcmn').DataTable({
            ordering: true,
	    order: [[2, 'asc']],
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
            ajax: "{{ url('api/cotizaciones_mn') }}",
            columns: [{
                    data: "consecutivo_mn",
                    "sClass": "center"
                },
                {
                    data: "cliente",
                    "sClass": "left"
                },
                {
                    data: "fecha",
                    "sClass": "center"
                },
                {
                    data: "tipooperacion",
                    "sClass": "center"
                },
                {
                    data: "tipocliente",
                    "sClass": "center"
                },
                {
                    data: "producto",
                    "sClass": "center"
                },
                {
                    data: "ejec",
                    "sClass": "center"
                },
                {
                    data: "reali",
                    "sClass": "center"
                },
                {
                    data: "EstadoC",
                    "sClass": "center"
                },
                {
                    class: "details-control",
                    orderable: false,
                    data: null,
                    defaultContent: '<td>' +
                        '<div class="action-buttons center">' +
                        '<a href="#modal-table" role="button" class="blue" data-toggle="modal">' +
                        '<i class="ace-icon fa fa-info-circle align-top bigger-150 icon-on-right"></i>' +
                        '</a>' +
                        '</div>' +
                        '</td>',
                },
            ],
            columnDefs: [{
                    targets: 2,
                    render: $.fn.dataTable.render.moment('DD/MM/YYYY')
                },
                {
                    targets: 8,
                    data: "EstadoC",
                    "render": function(data, type, row, meta) {
                        switch (data) {
                            case 'Anulada':
                                return '<span class="label label-sm label-danger arrowed">' + data +
                                    '</span>';
                                break;
                            case 'Aprobada':
                                return '<span class="label label-sm label-success arrowed-right">' + data +
                                    '</span>'
                                break;
                            case 'En espera':
                                return '<span class="label label-sm label-warning arrowed">' + data +
                                    '</span>'
                                break;
                            case 'En Proceso':
                                return '<span class="label label-sm label-warning arrowed">' + data +
                                    '</span>'
                                break;
                            case 'Finalizada':
                                return '<span class="label label-sm label-success arrowed-right">' + data +
                                    '</span>'
                                break;
                            case 'No Aprobada':
                                return '<span class="label label-sm label-danger  arrowed">' + data +
                                    '</span>'
                                break;
                            case 'Revisar Cotizacion':
                                return '<span class="label label-sm label-warning  arrowed">' + data +
                                    '</span>'
                                break;
                            case 'En espera de respuesta del agente':
                                return '<div class="estado label label-sm label-warning arrowed">' +
                                    'En espera<span class="tooltiptext">Respuesta del agente</span>' +
                                    '</div>'
                                break;
                            case 'En espera de respuesta del cliente':
                                return '<div class="estado label label-sm label-warning arrowed">' +
                                    'En espera<span class="tooltiptext">Respuesta del Cliente</span>' +
                                    '</div>'
                                break;
                            case 'Mudanza perdida por el agente':
                                return '<div class="estado label label-sm label-danger arrowed">' +
                                    'Inconformidad<span class="tooltiptext">Mudanza Perdida por Agente</span>' +
                                    '</div>'
                                break;
                            case 'Muy costoso para el cliente':
                                return '<div class="estado label label-sm label-danger arrowed">' +
                                    'Muy Costoso<span class="tooltiptext">Para el Cliente</span>' + '</div>'
                                break;
                            case 'Muy costoso para el agente':
                                return '<div class="estado label label-sm label-danger arrowed">' +
                                    'Muy Costoso<span class="tooltiptext">Para el Agente</span>' + '</div>'
                                break;
                            case 'Demora en el envio de la tarifa':
                                return '<div class="estado label label-sm label-danger arrowed">' +
                                    'Demora<span class="tooltiptext">Envio de Tarifa</span>' + '</div>'
                                break;
                            case 'Inconformidad con la logistica':
                                return '<div class="estado label label-sm label-danger arrowed">' +
                                    'Inconformidad<span class="tooltiptext">Con la Logistica</span>' +
                                    '</div>'
                                break;
                            case 'Mala Asesoria de la comercial':
                                return '<div class="estado label label-sm label-danger arrowed">' +
                                    'Inconformidad<span class="tooltiptext">Asesoria Comercial</span>' +
                                    '</div>'
                                break;
                            default:
                                return '<span class="label label-sm label-warning arrowed">' + data +
                                    '</span>'
                                break;
                        }
                    }
                }
            ],
        });

        $('#tcmn tbody').on('click', 'td.details-control', function() {
            var tr = $(this).closest('tr');
            var row = tabla_mn.row(tr);
            format(row.data());
        });

        $('#estado_id').select2();

        function format(d) {
            $('#estado_id').empty();
            $('#estado_id').append('<option value="">--Seleccione--</option>')
            $.ajax({
                url: "{{ url('api/estados_cot') }}",
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    $.each(response.data, function(key, value) {
                        // alert(value.estado);
                        $('#estado_id').append("<option value='" + value.estado_id + "'>" + value
                            .estado + "</option>");
                    });
                    $('#estado_id').find('[value=2]').remove();
                    $('#estado_id').find('[value=5]').remove();
                    $('#estado_id').find('[value=6]').remove();
                    $('#estado_id').find('[value=13]').remove();
                    $('#estado_id').find('[value=15]').remove();
                },
                error: function() {
                    alert('Hubo un error obteniendo las areas!');
                }
            });

            $('.cmn').html(d.consecutivo_mn);
            $('.tcot').html('Cotización Mercado Natural: ');
            if (d.cot_id != null) {
                $('#cot_id').val(d.cot_id);
                $('#enlace').attr('href', "http://186.29.91.156/Aviomar-Ace/public/pages/cotizaciones/" + d.cot_id +"/editar");
                //$('#enlace').attr('href', "http://192.168.0.10/Aviomar-Ace/public/pages/cotizaciones/" + d.cot_id +"/editar");
                /*$('#enlace').attr('href', "http://aviomar-ace.test/pages/cotizaciones/" + d.cot_id +
                    "/editar");*/
                switch (d.estado_id) {
                    case 3:
                        $('#panel_acciones').css("display", "none");
                        $('#estado_cot_a').css("display", "");
                        $('#estado_cot_na').css("display", "none");
                        break;
                    case 8:
                        $('#panel_acciones').css("display", "none");
                        $('#estado_cot_a').css("display", "none");
                        $('#estado_cot_na').css("display", "");
                        break;
                    default:
                        $('#panel_acciones').css("display", "");
                        $('#estado_cot_a').css("display", "none");
                        $('#estado_cot_na').css("display", "none");
                        $('#form-act_est').attr('action', "http://186.29.91.156/Aviomar-Ace/public/pages/cotizaciones/a/" +
                            d.cot_id);
                        //$('#form-act_est').attr('action', "http://aviomar-ace.test/pages/cotizaciones/a/" + d.cot_id);
                        /*$('#form-act_est').attr('action', "http://192.168.0.10/Aviomar-Ace/public/pages/cotizaciones/a/" + d.cot_id);*/
                        break;
                }
            };
            $('#tnotas > tbody').empty();
            $.ajax({
                url: "{{ url('api/notas') }}",
                type: 'GET',
                data: {
                    cot_id: $('#cot_id').val()
                },
                dataType: 'json',
                success: function(response) {
                    $.each(response.data, function(key, value) {
                        // alert($('#cot_id').val() + " " + value.cot_id + " " + value.comentario);
                        $('#datos_n').append('<tr><td style="width:150px">' + value.nombre + ' ' + value
                            .apellidos + '</td>' +
                            '<td align="center">' + moment(value.fecha).format('DD/MM/YYYY') + '</td>' +
                            '<td>' + value.comentario + '</td></tr>');
                    });
                },
                error: function() {
                    alert('Hubo un error obteniendo las areas!');
                }
            });
            $('.fecha_apr').css("display", "none");
            $.ajax({
                url: "{{ url('api/fecha_a') }}",
                type: 'GET',
                data: {
                    cot_id: $('#cot_id').val()
                },
                dataType: 'json',
                success: function(response) {
                    $.each(response.data, function(key, value) {
                        // alert($('#cot_id').val() + " " + value.fecha_a);

                        if (value.fecha_a == null) {
                            $('.fecha_apr').html("");
                        } else {
                            $('.fecha_apr').css("display", "");
                            $('.fecha_apr').html("Fecha Aprobación: " + moment(value.fecha_a).format(
                                'DD/MM/YYYY'));
                        };
                    });
                },
                error: function() {
                    alert('Hubo un error obteniendo las areas!');
                }
            });

            if (d.Controlador == null) {
                $('.controlador').html("-");
            } else {
                $('.controlador').html(d.Controlador + " | " + d.ControladorC);
            };
            if (d.AgenteO == null) {
                $('.AgenteO').html("-");
            } else {
                $('.AgenteO').html(d.AgenteO + " | " + d.AgenteOC);
            };
            if (d.valor_o == null) {
                $('.ValorO').html("-");
            } else {
                $('.ValorO').html(d.valor_o);
            };
            if (d.AgenteD == null) {
                $('.AgenteD').html("-");
            } else {
                $('.AgenteD').html(d.AgenteD + " | " + d.AgenteDC);
            };
            if (d.valor_d == null) {
                $('.ValorD').html("-");
            } else {
                $('.ValorD').html(d.valor_o);
            };
            if (d.facturar_a == null) {
                $('.FacturarA').html("-");
            } else {
                $('.FacturarA').html(d.facturar_a);
            };
            if (d.sucursal == null) {
                $('.Sucursal').html("-");
            } else {
                $('.Sucursal').html(d.sucursal);
            };
            if (d.empresa == null) {
                $('.Empresa').html("-");
            } else {
                $('.Empresa').html(d.empresa);
            };
            if (d.PaisO == null) {
                $('.Origen').html("-");
            } else {
                $('.Origen').html(d.CiudadO + ", " + d.PaisO);
            };
            if (d.PaisD == null) {
                $('.Destino').html("-");
            } else {
                $('.Destino').html(d.CiudadD + ", " + d.PaisD);
            };
            if (d.NombreE == null) {
                $('.Ejecutivo').html("-");
            } else {
                $('.Ejecutivo').html(d.NombreE + " " + d.ApellidosE);
            };
            if (d.NombreR == null) {
                $('.RealizadoP').html("-");
            } else {
                $('.RealizadoP').html(d.NombreR + " " + d.ApellidosR);
            };
            if (d.tipotransporte == null) {
                $('.Transporte').html("-");
            } else {
                $('.Transporte').html(d.tipotransporte);
            };
            if (d.tipotransporte == null) {
                $('.Transporte').html("-");
            } else {
                $('.Transporte').html(d.tipotransporte);
            };
            if (d.ttrans_id == 2) {
                $('.cbm').css("display", "none");
                $('.libras1').css("display", "none");
                $('.cbma').css("display", "");
                $('.libras2').css("display", "");
                $('.cbmm').css("display", "");
                $('.libras3').css("display", "");
            } else {
                $('.cbm').css("display", "");
                $('.libras1').css("display", "");
                $('.cbma').css("display", "none");
                $('.libras2').css("display", "none");
                $('.cbmm').css("display", "none");
                $('.libras3').css("display", "none");
            };

            if (d.cbm == null) {
                $('.CBM').html("-");
            } else {
                $('.CBM').html(d.cbm);
            };

            if (d.libras == null) {
                $('.Libras').html("-");
            } else {
                $('.Libras').html(d.libras);
            };

            if (d.cbm_a == null) {
                $('.CBMA').html("-");
            } else {
                $('.CBMA').html(d.cbm_a);
            };

            if (d.libras_a == null) {
                $('.LibrasA').html("-");
            } else {
                $('.LibrasA').html(d.libras_a);
            };

            if (d.cbm_m == null) {
                $('.CBMM').html("-");
            } else {
                $('.CBMM').html(d.cbm_m);
            };

            if (d.libras_m == null) {
                $('.LibrasM').html("-");
            } else {
                $('.LibrasM').html(d.libras_m);
            };
        }
    </script>
@endsection

@section('contenido')
    <div class="main-content">
        <div class="col-sm-12 widget-container-col" id="widget-container-col-9">
            <div class="row">
                <div class="col-xs-12 col-sm-12 widget-container-col" id="widget-container-col-3">
                    <div class="widget-box widget-color-orange" id="widget-box-3">
                        <div class="widget-header widget-header-small">
                            <h2 class="widget-title">Cotizaciones Mercado Natural</h2>
                            <div class="widget-toolbar">
                                <a href="{{ route('crear_cotizacion') }}"
                                    class="btn btn-outline-secondary btn-sm btn-info btn-round table-responsive">
                                    <i class="fa fa-fw fa-plus-circle"></i> Crear Cotización
                                </a>
                            </div>
                        </div>
                        <div class="widget-body">
                            <div class="widget-main">
                                <div class="row">
                                    <table id="tcmn" class="table table-sm table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th
                                                    style="background: linear-gradient(to bottom, #82af6f 0%, #2e4c21 100%);color: rgb(255, 255, 255);width: 70px;">
                                                    #</th>
                                                <th
                                                    style="background: linear-gradient(to bottom, #82af6f 0%, #2e4c21 100%);color: rgb(255, 255, 255); text-align: center;">
                                                    Cliente</th>
                                                <th
                                                    style="background: linear-gradient(to bottom, #82af6f 0%, #2e4c21 100%);color: rgb(255, 255, 255);">
                                                    Fecha</th>
                                                <th
                                                    style="background: linear-gradient(to bottom, #82af6f 0%, #2e4c21 100%);color: rgb(255, 255, 255);">
                                                    Operación</th>
                                                <th
                                                    style="background: linear-gradient(to bottom, #82af6f 0%, #2e4c21 100%);color: rgb(255, 255, 255);">
                                                    Tipo Cliente</th>
                                                <th
                                                    style="background: linear-gradient(to bottom, #82af6f 0%, #2e4c21 100%);color: rgb(255, 255, 255);">
                                                    Producto</th>
                                                <th
                                                    style="background: linear-gradient(to bottom, #82af6f 0%, #2e4c21 100%);color: rgb(255, 255, 255);">
                                                    Ejecutivo</th>
                                                <th
                                                    style="background: linear-gradient(to bottom, #82af6f 0%, #2e4c21 100%);color: rgb(255, 255, 255);">
                                                    Realizado Por</th>
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
                                        <div class="col-sm-1">
                                            <div class="form-group">
                                                <label for="form-control"><b>#</b></label>
                                                <input type="text" class="form-control input-sm text-center" id="cot_mn"
                                                    name="cot_mn">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <div>
                                                    <label for="form-control"><b>Cliente</b></label>
                                                    <input type="text" class="form-control input-sm text-center"
                                                        id="cliente" name="cliente" style="width: 100%;">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label for="form-control"><b>Operación</b></label>
                                                <div>
                                                    <select class="form-control input-sm" style="width: 100%;" id="ope"
                                                        name="ope">
                                                        <option value="">---</option>
                                                        @foreach ($tipooperaciones as $tipooperacion)
                                                            <option value="{{ $tipooperacion->toper_id }}">
                                                                {{ $tipooperacion->tipooperacion }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label for="form-control"><b>Tipo Cliente</b></label>
                                                <div>
                                                    <select class="form-control input-sm" style="width: 100%;" id="tcli"
                                                        name="tcli">
                                                        <option value="">---</option>
                                                        @foreach ($tipoclientes as $tipocliente)
                                                            <option value="{{ $tipocliente->tcliente_id }}">
                                                                {{ $tipocliente->tipocliente }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label for="form-control"><b>Producto</b></label>
                                                <div>
                                                    <select class="form-control input-sm" style="width: 100%;" id="prod"
                                                        name="prod">
                                                        <option value="">---</option>
                                                        @foreach ($productos as $producto)
                                                            <option value="{{ $producto->producto_id }}">
                                                                {{ $producto->producto }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label for="form-control"><b>Estado</b></label>
                                                <div>
                                                    <select class="form-control select2bs4 input-sm" style="width: 100%;"
                                                        id="est" name="est">
                                                        <option value="">---</option>
                                                        @foreach ($estados as $estado)
                                                            <option value="{{ $estado->estado_id }}">
                                                                {{ $estado->estado }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="form-control"><b>Ejecutivo</b></label>
                                                <div>
                                                    <select class="form-control select2bs4 input-sm" style="width: 100%;"
                                                        id="ejecutivo" name="ejecutivo">
                                                        <option value="">---</option>
                                                        @foreach ($users as $user)
                                                            <option value="{{ $user->id }}">
                                                                {{ $user->full_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="form-control"><b>Realizado por</b></label>
                                                <div>
                                                    <select class="form-control select2bs4 input-sm" style="width: 100%;"
                                                        id="realizado" name="realizado">
                                                        <option value="">---</option>
                                                        @foreach ($users as $user)
                                                            <option value="{{ $user->id }}">
                                                                {{ $user->full_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('pages.cotizaciones.modal_cot')
                </div>
            </div>
        </div>
    </div>
@endsection
