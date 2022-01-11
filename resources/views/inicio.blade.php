@extends("theme.$theme.layout")
@section("titulo")
Cotizaciones Mercado Natural
@endsection

@section("styles")
<link href="{{asset("assets/js/jquery-nestable/jquery.nestable.css")}}" rel="stylesheet" type="text/css" />
@endsection

@section("scriptsPlugins")
<script src="{{asset("assets/js/jquery-nestable/jquery.nestable.js")}}" type="text/javascript"></script>
@endsection

@section("scripts")
<script src="{{asset("assets/$theme/js/dataTables/jquery.dataTables.js")}}"></script>
<script src="{{asset("assets/$theme/js/dataTables/jquery.dataTables.bootstrap.js")}}"></script>
<script src="{{asset("assets/$theme/js/dataTables/extensions/Buttons/js/dataTables.buttons.js")}}"></script>
<script src="{{asset("assets/$theme/js/dataTables/extensions/Buttons/js/buttons.flash.js")}}"></script>
<script src="{{asset("assets/$theme/js/dataTables/extensions/Buttons/js/buttons.html5.js")}}"></script>
<script src="{{asset("assets/$theme/js/dataTables/extensions/Buttons/js/buttons.print.js")}}"></script>
<script src="{{asset("assets/$theme/js/dataTables/extensions/Buttons/js/buttons.colVis.js")}}"></script>
<script src="{{asset("assets/$theme/js/dataTables/extensions/Select/js/dataTables.select.js")}}"></script>
<script src="{{asset("assets/$theme/js/date-time/moment.js")}}"></script>
<script src="//cdn.datatables.net/plug-ins/1.10.25/dataRender/datetime.js"></script>
<script>
    var tabla_mn = $('#tcmn').DataTable({
        ordering: true,
        dom: "<'col-xs-12't>" + "<'col-xs-12 col-md-4 tableTools-container1'><'col-xs-12 col-md-3 center'i><'col-xs-12 col-md-5'p>",
        lengthChange: true,
        scrollY: "380px",
        serverSide: true,
        ajax: "{{ url('api/cotizaciones_mn')}}",
        columns: [
            {data: "consecutivo_mn", "sClass": "center"},
            {data: "cliente" },
            {data: "fecha", "sClass": "center" },
            {data: "tipooperacion", "sClass": "center"},
            {data: "tipocliente", "sClass": "center"},
            {data: "producto", "sClass": "center"},
            {data: "EstadoC", "sClass": "center"},
            {
                class:          "details-control",
                orderable:      false,
                data:           null,
                defaultContent:   '<td>'+
                                        '<div class="action-buttons center">'+
                                            '<a href="#modal-table" role="button" class="blue" data-toggle="modal">'+
                                                '<i class="ace-icon fa fa-info-circle align-top bigger-150 icon-on-right"></i>'+
                                            '</a>'+
                                        '</div>'+
                                    '</td>',
            },
        ],
        columnDefs: [{
            targets: 2,
            render: $.fn.dataTable.render.moment('DD/MM/YYYY')
        },
        {
            targets: 6,
            data: "EstadoC",
            "render": function ( data, type, row, meta ) {
                switch (data) {
                    case 'Anulada':
                        return '<span class="label label-sm label-danger arrowed">'+data+'</span>';
                        break;
                    case 'Aprobada':
                        return '<span class="label label-sm label-success arrowed-right">'+data+'</span>'
                        break;
                    case 'En espera':
                        return '<span class="label label-sm label-warning arrowed">'+data+'</span>'
                        break;
                    case 'En Proceso':
                        return '<span class="label label-sm label-warning arrowed">'+data+'</span>'
                        break;
                    case 'Finalizada':
                        return '<span class="label label-sm label-success arrowed-right">'+data+'</span>'
                        break;
                    case 'No Aprobada':
                        return '<span class="label label-sm label-danger  arrowed">'+data+'</span>'
                        break;
                    default:
                        return '<span class="label label-sm label-warning arrowed">'+data+'</span>'
                        break;
                }
            }
        }],
    });
</script>
<script src="{{asset("assets/js/data_cotizacion_mn.js")}}" type="text/javascript"></script>
@endsection

@section('contenido')
<div class="main-content">
    <div class="main-content-inner">
        <div class="page-content">
            
        </div>
    </div>
</div>
@endsection