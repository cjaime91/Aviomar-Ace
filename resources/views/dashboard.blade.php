@extends("theme.$theme.layout")
@section('titulo')
    Dashboard
@endsection

@if (Auth::check())
    @section('styles')
        <link href="{{ asset('assets/js/jquery-nestable/jquery.nestable.css') }}" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="{{ asset("assets/$theme/css/ace.css") }}" class="ace-main-stylesheet"
            id="main-ace-style" />
        <link rel="stylesheet"
            href="{{ asset('assets/js/datatables/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet"
            href="{{ asset('assets/js/datatables/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
        <link rel="stylesheet"
            href="{{ asset('assets/js/datatables/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset("assets/css/dashboard.css") }}">
        
    @endsection

    @section('scriptsPlugins')
        <script src="{{ asset('assets/js/jquery-nestable/jquery.nestable.js') }}" type="text/javascript"></script>
    @endsection

    @section('scripts')
        <script src="https://code.highcharts.com/highcharts.js"> </script>
        <script src="https://code.highcharts.com/highcharts-3d.js"></script>
        <script src="https://code.highcharts.com/modules/data.js"></script>
        <script src="https://code.highcharts.com/modules/cylinder.js"></script>
        <script src="https://code.highcharts.com/highcharts-more.js"></script>
        <script src="https://code.highcharts.com/modules/accessibility.js"></script>
        <script src="https://code.highcharts.com/modules/variable-pie.js"></script>
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
        <script src="{{ asset("assets/$theme/js/ace/elements.scroller.js") }}"></script>
        <script src="{{ asset("assets/$theme/js/ace/ace.widget-on-reload.js") }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="{{ asset("assets/$theme/js/date-time/moment.js") }}"></script>
        <script>
            $('#mercado').select2();
            $('#mes').select2();
            $('#anio').select2();
            $meses_mn = [];
            $.ajax({
                url: "{{ url('api/mercados') }}",
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    $.each(response.data, function(key, value) {
                        $meses_mn[key] = {
                            'name': value.name,
                            'y': value.cuenta
                        }
                    });
                    datos_meses($meses_mn);
                },
                error: function() {
                    alert('Hubo un error obteniendo las ciudades!');
                }
            });

            $estados = [];
            $.ajax({
                url: "{{ url('api/estados') }}",
                type: 'GET',
                data: {
                    "mes": $('#mes').val(),
                    "mercado": $('#mercado').val()
                },
                dataType: 'json',
                success: function(response) {
                    var colores = [];
                    $.each(response.data, function(key, value) {
                        $estados[key] = {
                            'name': value.name,
                            'y': value.cuenta
                        }
                        var brightness = 0.1;
                        colores.push(value.color);
                    });
                    Highcharts.getOptions().colors = Highcharts.map(colores, function(color) {
                        return {
                            radialGradient: {
                                cx: 0.5,
                                cy: 0.3,
                                r: 0.7
                            },
                            stops: [
                                [0, color],
                                [1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
                            ]
                        };
                    });
                    dato_estados($estados);
                },
                error: function() {
                    alert('Hubo un error obteniendo dato de los estados!');
                }
            });

            $productos_m = [0, 0, 0, 0, 0, 0, 0];
            $productos_ap = [0, 0, 0, 0, 0, 0, 0];

            $.ajax({
                url: "{{ url('api/productos_m') }}",
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    $.each(response.data, function(key, value) {
                        switch (value.producto) {
                            case 'Bodegaje':
                                $productos_m[0] = {
                                    'name': value.producto,
                                    'y': value.Solicitadas
                                }
                                $productos_ap[0] = {
                                    'name': value.producto,
                                    'y': value.Aprobadas
                                }
                                break;
                            case 'Carga Diplomatica':
                                $productos_m[1] = {
                                    'name': value.producto,
                                    'y': value.Solicitadas
                                }
                                $productos_ap[1] = {
                                    'name': value.producto,
                                    'y': value.Aprobadas
                                }
                                break;
                            case 'Licitaciones':
                                $productos_m[2] = {
                                    'name': value.producto,
                                    'y': value.Solicitadas
                                }
                                $productos_ap[2] = {
                                    'name': value.producto,
                                    'y': value.Aprobadas
                                }
                                break;
                            case 'Mascota':
                                $productos_m[3] = {
                                    'name': value.producto,
                                    'y': value.Solicitadas
                                }
                                $productos_ap[3] = {
                                    'name': value.producto,
                                    'y': value.Aprobadas
                                }
                                break;
                            case 'Menaje':
                                $productos_m[4] = {
                                    'name': value.producto,
                                    'y': value.Solicitadas
                                }
                                $productos_ap[4] = {
                                    'name': value.producto,
                                    'y': value.Aprobadas
                                }
                                break;
                            case 'Nacionalizacion':
                                $productos_m[5] = {
                                    'name': value.producto,
                                    'y': value.Solicitadas
                                }
                                $productos_ap[5] = {
                                    'name': value.producto,
                                    'y': value.Aprobadas
                                }
                                break;
                            case 'Obra de Arte':
                                $productos_m[6] = {
                                    'name': value.producto,
                                    'y': value.Solicitadas
                                }
                                $productos_ap[6] = {
                                    'name': value.producto,
                                    'y': value.Aprobadas
                                }
                                break;
                            case 'Vehiculo':
                                $productos_m[7] = {
                                    'name': value.producto,
                                    'y': value.Solicitadas
                                }
                                $productos_ap[7] = {
                                    'name': value.producto,
                                    'y': value.Aprobadas
                                }
                                break;
                        }
                    });
                    datos_productos($productos_m, $productos_ap);
                },
                error: function() {
                    alert('Hubo un error obteniendo dato de los estados!');
                }
            });

            $operaciones_m = [0, 0, 0, 0, 0];
            $operaciones_ap = [0, 0, 0, 0, 0];

            $.ajax({
                url: "{{ url('api/operaciones_m') }}",
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    $.each(response.data, function(key, value) {
                        switch (value.tipooperacion) {
                            case 'Exportación':
                                $operaciones_m[0] = {
                                    'name': value.tipooperacion,
                                    'y': value.Solicitadas
                                };
                                $operaciones_ap[0] = {
                                    'name': value.tipooperacion,
                                    'y': value.Aprobadas
                                }
                                break;
                            case 'Importación':
                                $operaciones_m[1] = {
                                    'name': value.tipooperacion,
                                    'y': value.Solicitadas
                                };
                                $operaciones_ap[1] = {
                                    'name': value.tipooperacion,
                                    'y': value.Aprobadas
                                }
                                break;
                            case 'Liberación de Guia':
                                $operaciones_m[2] = {
                                    'name': value.tipooperacion,
                                    'y': value.Solicitadas
                                };
                                $operaciones_ap[2] = {
                                    'name': value.tipooperacion,
                                    'y': value.Aprobadas
                                }
                                break;
                            case 'Nacional/Local':
                                $operaciones_m[3] = {
                                    'name': value.tipooperacion,
                                    'y': value.Solicitadas
                                };
                                $operaciones_ap[3] = {
                                    'name': value.tipooperacion,
                                    'y': value.Aprobadas
                                }
                                break;
                            case 'Traspaso':
                                $operaciones_m[4] = {
                                    'name': value.tipooperacion,
                                    'y': value.Solicitadas
                                };
                                $operaciones_ap[4] = {
                                    'name': value.tipooperacion,
                                    'y': value.Aprobadas
                                }
                                break;
                        }
                    });
                    datos_operaciones($operaciones_m, $operaciones_ap);
                },
                error: function() {
                    alert('Hubo un error obteniendo dato de los estados!');
                }
            });

            $paises_l = [];
            $paises_sl = [];
            $paises_ap = [];

            $('#tabla_paises').DataTable({
                ordering: false,
                dom: "<'col-xs-12't>",
                lengthChange: true,
                scrollY: "540px",
                serverSide: true,
                ajax: "{{ url('api/paises_sl') }}",
                columns: [{
                        data: "pais",
                        "sClass": "left"
                    },
                    {
                        data: "Solicitadas",
                        "sClass": "center"
                    },
                    {
                        data: "Aprobadas",
                        "sClass": "center"
                    }
                ],
            });

            $('#tabla_paises > tbody').empty();
            $.ajax({
                url: "{{ url('api/paises_sl') }}",
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    $.each(response.data, function(key, value) {
                        $paises_sl[key] = {
                            'name': value.pais,
                            'y': value.Solicitadas
                        };
                        $paises_ap[key] = {
                            'name': value.pais,
                            'y': value.Aprobadas
                        };
                        $paises_l[key] = value.pais
                    });
                    datos_paises($paises_sl, $paises_ap, $paises_l);
                },
                error: function() {
                    alert('Hubo un error obteniendo dato de los paises solicitados!');
                }
            });


            $('#tabla_agentes').DataTable({
                ordering: false,
                dom: "<'col-xs-12't>",
                lengthChange: true,
                scrollY: "720px",
                serverSide: true,
                ajax: "{{ url('api/agentes_c') }}",
                columns: [{
                        data: "razon_social",
                        "sClass": "left"
                    },
                    {
                        data: "Solicitadas",
                        "sClass": "center"
                    },
                    {
                        data: "Aprobadas",
                        "sClass": "center"
                    }
                ],
            });

            $agentes_l = [];
            $agentes_sl = [];
            $agentes_ap = [];

            $('#tabla_agentes > tbody').empty();
            $.ajax({
                url: "{{ url('api/agentes_c') }}",
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    $.each(response.data, function(key, value) {
                        $agentes_sl[key] = {
                            'name': value.razon_social,
                            'y': value.Solicitadas
                        };
                        $agentes_ap[key] = {
                            'name': value.razon_social,
                            'y': value.Aprobadas
                        };
                        $agentes_l[key] = value.razon_social
                    });
                    datos_agentes($agentes_sl, $agentes_ap, $agentes_l);
                },
                error: function() {
                    alert('Hubo un error obteniendo dato de los paises solicitados!');
                }
            });


            $('#mercado').change(function() {
                $meses_mn = [];
                $.ajax({
                    url: "{{ url('api/mercados') }}",
                    type: 'GET',
                    data: {
                        "mercado": $('#mercado').val(),
                        "anio": $('#anio').val()
                    },
                    dataType: 'json',
                    success: function(response) {
                        $.each(response.data, function(key, value) {
                            $meses_mn[key] = value.cuenta
                        });
                        datos_meses($meses_mn);
                    },
                    error: function() {
                        alert('Hubo un error obteniendo las ciudades!');
                    }
                });
                $estados = [];
                $.ajax({
                    url: "{{ url('api/estados') }}",
                    type: 'GET',
                    data: {
                        "mes": $('#mes').val(),
                        "mercado": $('#mercado').val(),
                        "anio": $('#anio').val()
                    },
                    dataType: 'json',
                    success: function(response) {
                        var colores = [];
                        $.each(response.data, function(key, value) {
                            $estados[key] = {
                                'name': value.name,
                                'y': value.cuenta
                            }
                            var brightness = 0.1;
                            colores.push(value.color);
                        });
                        Highcharts.getOptions().colors = Highcharts.map(colores, function(color) {
                            return {
                                radialGradient: {
                                    cx: 0.5,
                                    cy: 0.3,
                                    r: 0.7
                                },
                                stops: [
                                    [0, color],
                                    [1, Highcharts.Color(color).brighten(-0.3).get(
                                        'rgb')] // darken
                                ]
                            };
                        });
                        dato_estados($estados);
                    },
                    error: function() {
                        alert('Hubo un error obteniendo dato de los estados! ' + $('#mercado').val());
                    }
                });

                $productos_m = [0, 0, 0, 0, 0, 0, 0];
                $productos_ap = [0, 0, 0, 0, 0, 0, 0];

                $.ajax({
                    url: "{{ url('api/productos_m') }}",
                    type: 'GET',
                    data: {
                        "mes": $('#mes').val(),
                        "mercado": $('#mercado').val(),
                        "anio": $('#anio').val()
                    },
                    dataType: 'json',
                    success: function(response) {
                        $.each(response.data, function(key, value) {
                            switch (value.producto) {
                                case 'Bodegaje':
                                    $productos_m[0] = {
                                        'name': value.producto,
                                        'y': value.Solicitadas
                                    }
                                    $productos_ap[0] = {
                                        'name': value.producto,
                                        'y': value.Aprobadas
                                    }
                                    break;
                                case 'Carga Diplomatica':
                                    $productos_m[1] = {
                                        'name': value.producto,
                                        'y': value.Solicitadas
                                    }
                                    $productos_ap[1] = {
                                        'name': value.producto,
                                        'y': value.Aprobadas
                                    }
                                    break;
                                case 'Licitaciones':
                                    $productos_m[2] = {
                                        'name': value.producto,
                                        'y': value.Solicitadas
                                    }
                                    $productos_ap[2] = {
                                        'name': value.producto,
                                        'y': value.Aprobadas
                                    }
                                    break;
                                case 'Mascota':
                                    $productos_m[3] = {
                                        'name': value.producto,
                                        'y': value.Solicitadas
                                    }
                                    $productos_ap[3] = {
                                        'name': value.producto,
                                        'y': value.Aprobadas
                                    }
                                    break;
                                case 'Menaje':
                                    $productos_m[4] = {
                                        'name': value.producto,
                                        'y': value.Solicitadas
                                    }
                                    $productos_ap[4] = {
                                        'name': value.producto,
                                        'y': value.Aprobadas
                                    }
                                    break;
                                case 'Nacionalizacion':
                                    $productos_m[5] = {
                                        'name': value.producto,
                                        'y': value.Solicitadas
                                    }
                                    $productos_ap[5] = {
                                        'name': value.producto,
                                        'y': value.Aprobadas
                                    }
                                    break;
                                case 'Obra de Arte':
                                    $productos_m[6] = {
                                        'name': value.producto,
                                        'y': value.Solicitadas
                                    }
                                    $productos_ap[6] = {
                                        'name': value.producto,
                                        'y': value.Aprobadas
                                    }
                                    break;
                                case 'Vehiculo':
                                    $productos_m[7] = {
                                        'name': value.producto,
                                        'y': value.Solicitadas
                                    }
                                    $productos_ap[7] = {
                                        'name': value.producto,
                                        'y': value.Aprobadas
                                    }
                                    break;
                            }
                        });
                        datos_productos($productos_m, $productos_ap);
                    },
                    error: function() {
                        alert('Hubo un error obteniendo dato de los estados!');
                    }
                });

                $operaciones_m = [0, 0, 0, 0, 0];
                $operaciones_ap = [0, 0, 0, 0, 0];

                $.ajax({
                    url: "{{ url('api/operaciones_m') }}",
                    type: 'GET',
                    data: {
                        "mes": $('#mes').val(),
                        "mercado": $('#mercado').val(),
                        "anio": $('#anio').val()
                    },
                    dataType: 'json',
                    success: function(response) {
                        $.each(response.data, function(key, value) {
                            switch (value.tipooperacion) {
                                case 'Exportación':
                                    $operaciones_m[0] = {
                                        'name': value.tipooperacion,
                                        'y': value.Solicitadas
                                    };
                                    $operaciones_ap[0] = {
                                        'name': value.tipooperacion,
                                        'y': value.Aprobadas
                                    }
                                    break;
                                case 'Importación':
                                    $operaciones_m[1] = {
                                        'name': value.tipooperacion,
                                        'y': value.Solicitadas
                                    };
                                    $operaciones_ap[1] = {
                                        'name': value.tipooperacion,
                                        'y': value.Aprobadas
                                    }
                                    break;
                                case 'Liberación de Guia':
                                    $operaciones_m[2] = {
                                        'name': value.tipooperacion,
                                        'y': value.Solicitadas
                                    };
                                    $operaciones_ap[2] = {
                                        'name': value.tipooperacion,
                                        'y': value.Aprobadas
                                    }
                                    break;
                                case 'Nacional/Local':
                                    $operaciones_m[3] = {
                                        'name': value.tipooperacion,
                                        'y': value.Solicitadas
                                    };
                                    $operaciones_ap[3] = {
                                        'name': value.tipooperacion,
                                        'y': value.Aprobadas
                                    }
                                    break;
                                case 'Traspaso':
                                    $operaciones_m[4] = {
                                        'name': value.tipooperacion,
                                        'y': value.Solicitadas
                                    };
                                    $operaciones_ap[4] = {
                                        'name': value.tipooperacion,
                                        'y': value.Aprobadas
                                    }
                                    break;
                            }
                        });
                        datos_operaciones($operaciones_m, $operaciones_ap);
                    },
                    error: function() {
                        alert('Hubo un error obteniendo dato de los estados!');
                    }
                });
                $paises_l = [];
                $paises_sl = [];
                $paises_ap = [];

                $('#tabla_paises > tbody').empty();
                $.ajax({
                    url: "{{ url('api/paises_sl') }}",
                    type: 'GET',
                    data: {
                        "mes": $('#mes').val(),
                        "mercado": $('#mercado').val(),
                        "anio": $('#anio').val()
                    },
                    dataType: 'json',
                    success: function(response) {
                        $.each(response.data, function(key, value) {
                            $('#tabla_paises').append('<tr><td>' + value.pais +
                                '</td>' +
                                '<td class="center">' + value.Solicitadas + '</td>' +
                                '<td class="center">' + value.Aprobadas + '</td></tr>');
                            $paises_sl[key] = {
                                'name': value.pais,
                                'y': value.Solicitadas
                            };
                            $paises_ap[key] = {
                                'name': value.pais,
                                'y': value.Aprobadas
                            };
                            $paises_l[key] = value.pais
                        });
                        datos_paises($paises_sl, $paises_ap, $paises_l);
                    },
                    error: function() {
                        alert('Hubo un error obteniendo dato de los paises solicitados!');
                    }
                });


                $agentes_l = [];
                $agentes_sl = [];
                $agentes_ap = [];

                $('#tabla_agentes > tbody').empty();
                $.ajax({
                    url: "{{ url('api/agentes_c') }}",
                    type: 'GET',
                    data: {
                        "mes": $('#mes').val(),
                        "mercado": $('#mercado').val(),
                        "anio": $('#anio').val()
                    },
                    dataType: 'json',
                    success: function(response) {
                        $.each(response.data, function(key, value) {
                            $('#tabla_agentes').append('<tr><td>' + value.razon_social + '</td>' +
                                '<td class="center">' + value.Solicitadas + '</td>' +
                                '<td class="center">' + value.Aprobadas + '</td></tr>');
                            $agentes_sl[key] = {
                                'name': value.razon_social,
                                'y': value.Solicitadas
                            };
                            $agentes_ap[key] = {
                                'name': value.razon_social,
                                'y': value.Aprobadas
                            };
                            $agentes_l[key] = value.razon_social
                        });
                        datos_agentes($agentes_sl, $agentes_ap, $agentes_l);
                    },
                    error: function() {
                        alert('Hubo un error obteniendo dato de los paises solicitados!');
                    }
                });
            });


            $('#mes').change(function() {
                $estados = [];
                $.ajax({
                    url: "{{ url('api/estados') }}",
                    type: 'GET',
                    data: {
                        "mes": $('#mes').val(),
                        "mercado": $('#mercado').val(),
                        "anio": $('#anio').val()
                    },
                    dataType: 'json',
                    success: function(response) {
                        var colores = [];
                        $.each(response.data, function(key, value) {
                            $estados[key] = {
                                'name': value.name,
                                'y': value.cuenta
                            }
                            var brightness = 0.1;
                            colores.push(value.color);
                        });
                        Highcharts.getOptions().colors = Highcharts.map(colores, function(color) {
                            return {
                                radialGradient: {
                                    cx: 0.5,
                                    cy: 0.3,
                                    r: 0.7
                                },
                                stops: [
                                    [0, color],
                                    [1, Highcharts.Color(color).brighten(-0.3).get(
                                        'rgb')] // darken
                                ]
                            };
                        });
                        dato_estados($estados);
                    },
                    error: function() {
                        alert('Hubo un error obteniendo dato de los estados! ' + $('#mercado').val());
                    }
                });
                $productos_m = [0, 0, 0, 0, 0, 0, 0];
                $productos_ap = [0, 0, 0, 0, 0, 0, 0];

                $.ajax({
                    url: "{{ url('api/productos_m') }}",
                    type: 'GET',
                    data: {
                        "mes": $('#mes').val(),
                        "mercado": $('#mercado').val(),
                        "anio": $('#anio').val()
                    },
                    dataType: 'json',
                    success: function(response) {
                        $.each(response.data, function(key, value) {
                            switch (value.producto) {
                                case 'Bodegaje':
                                    $productos_m[0] = {
                                        'name': value.producto,
                                        'y': value.Solicitadas
                                    }
                                    $productos_ap[0] = {
                                        'name': value.producto,
                                        'y': value.Aprobadas
                                    }
                                    break;
                                case 'Carga Diplomatica':
                                    $productos_m[1] = {
                                        'name': value.producto,
                                        'y': value.Solicitadas
                                    }
                                    $productos_ap[1] = {
                                        'name': value.producto,
                                        'y': value.Aprobadas
                                    }
                                    break;
                                case 'Licitaciones':
                                    $productos_m[2] = {
                                        'name': value.producto,
                                        'y': value.Solicitadas
                                    }
                                    $productos_ap[2] = {
                                        'name': value.producto,
                                        'y': value.Aprobadas
                                    }
                                    break;
                                case 'Mascota':
                                    $productos_m[3] = {
                                        'name': value.producto,
                                        'y': value.Solicitadas
                                    }
                                    $productos_ap[3] = {
                                        'name': value.producto,
                                        'y': value.Aprobadas
                                    }
                                    break;
                                case 'Menaje':
                                    $productos_m[4] = {
                                        'name': value.producto,
                                        'y': value.Solicitadas
                                    }
                                    $productos_ap[4] = {
                                        'name': value.producto,
                                        'y': value.Aprobadas
                                    }
                                    break;
                                case 'Nacionalizacion':
                                    $productos_m[5] = {
                                        'name': value.producto,
                                        'y': value.Solicitadas
                                    }
                                    $productos_ap[5] = {
                                        'name': value.producto,
                                        'y': value.Aprobadas
                                    }
                                    break;
                                case 'Obra de Arte':
                                    $productos_m[6] = {
                                        'name': value.producto,
                                        'y': value.Solicitadas
                                    }
                                    $productos_ap[6] = {
                                        'name': value.producto,
                                        'y': value.Aprobadas
                                    }
                                    break;
                                case 'Vehiculo':
                                    $productos_m[7] = {
                                        'name': value.producto,
                                        'y': value.Solicitadas
                                    }
                                    $productos_ap[7] = {
                                        'name': value.producto,
                                        'y': value.Aprobadas
                                    }
                                    break;
                            }
                        });
                        datos_productos($productos_m, $productos_ap);
                    },
                    error: function() {
                        alert('Hubo un error obteniendo dato de los estados!');
                    }
                });

                $operaciones_m = [0, 0, 0, 0, 0];
                $operaciones_ap = [0, 0, 0, 0, 0];

                $.ajax({
                    url: "{{ url('api/operaciones_m') }}",
                    type: 'GET',
                    data: {
                        "mes": $('#mes').val(),
                        "mercado": $('#mercado').val(),
                        "anio": $('#anio').val()
                    },
                    dataType: 'json',
                    success: function(response) {
                        $.each(response.data, function(key, value) {
                            switch (value.tipooperacion) {
                                case 'Exportación':
                                    $operaciones_m[0] = {
                                        'name': value.tipooperacion,
                                        'y': value.Solicitadas
                                    };
                                    $operaciones_ap[0] = {
                                        'name': value.tipooperacion,
                                        'y': value.Aprobadas
                                    }
                                    break;
                                case 'Importación':
                                    $operaciones_m[1] = {
                                        'name': value.tipooperacion,
                                        'y': value.Solicitadas
                                    };
                                    $operaciones_ap[1] = {
                                        'name': value.tipooperacion,
                                        'y': value.Aprobadas
                                    }
                                    break;
                                case 'Liberación de Guia':
                                    $operaciones_m[2] = {
                                        'name': value.tipooperacion,
                                        'y': value.Solicitadas
                                    };
                                    $operaciones_ap[2] = {
                                        'name': value.tipooperacion,
                                        'y': value.Aprobadas
                                    }
                                    break;
                                case 'Nacional/Local':
                                    $operaciones_m[3] = {
                                        'name': value.tipooperacion,
                                        'y': value.Solicitadas
                                    };
                                    $operaciones_ap[3] = {
                                        'name': value.tipooperacion,
                                        'y': value.Aprobadas
                                    }
                                    break;
                                case 'Traspaso':
                                    $operaciones_m[4] = {
                                        'name': value.tipooperacion,
                                        'y': value.Solicitadas
                                    };
                                    $operaciones_ap[4] = {
                                        'name': value.tipooperacion,
                                        'y': value.Aprobadas
                                    }
                                    break;
                            }
                        });
                        datos_operaciones($operaciones_m, $operaciones_ap);
                    },
                    error: function() {
                        alert('Hubo un error obteniendo dato de los estados!');
                    }
                });
                $paises_l = [];
                $paises_sl = [];
                $paises_ap = [];

                $('#tabla_paises > tbody').empty();
                $.ajax({
                    url: "{{ url('api/paises_sl') }}",
                    type: 'GET',
                    data: {
                        "mes": $('#mes').val(),
                        "mercado": $('#mercado').val(),
                        "anio": $('#anio').val()
                    },
                    dataType: 'json',
                    success: function(response) {
                        $.each(response.data, function(key, value) {
                            $('#tabla_paises').append('<tr><td>' + value.pais +
                                '</td>' +
                                '<td class="center">' + value.Solicitadas + '</td>' +
                                '<td class="center">' + value.Aprobadas + '</td></tr>');
                            $paises_sl[key] = {
                                'name': value.pais,
                                'y': value.Solicitadas
                            };
                            $paises_ap[key] = {
                                'name': value.pais,
                                'y': value.Aprobadas
                            };
                            $paises_l[key] = value.pais
                        });
                        datos_paises($paises_sl, $paises_ap, $paises_l);
                    },
                    error: function() {
                        alert('Hubo un error obteniendo dato de los paises solicitados!');
                    }
                });


                $agentes_l = [];
                $agentes_sl = [];
                $agentes_ap = [];

                $('#tabla_agentes > tbody').empty();
                $.ajax({
                    url: "{{ url('api/agentes_c') }}",
                    type: 'GET',
                    data: {
                        "mes": $('#mes').val(),
                        "mercado": $('#mercado').val(),
                        "anio": $('#anio').val()
                    },
                    dataType: 'json',
                    success: function(response) {
                        $.each(response.data, function(key, value) {
                            $('#tabla_agentes').append('<tr><td>' + value.razon_social + '</td>' +
                                '<td class="center">' + value.Solicitadas + '</td>' +
                                '<td class="center">' + value.Aprobadas + '</td></tr>');
                            $agentes_sl[key] = {
                                'name': value.razon_social,
                                'y': value.Solicitadas
                            };
                            $agentes_ap[key] = {
                                'name': value.razon_social,
                                'y': value.Aprobadas
                            };
                            $agentes_l[key] = value.razon_social
                        });
                        datos_agentes($agentes_sl, $agentes_ap, $agentes_l);
                    },
                    error: function() {
                        alert('Hubo un error obteniendo dato de los paises solicitados!');
                    }
                });
            });

            $('#anio').change(function() {
		$mes = $('#mes').val();
                $anio = $('#anio').val();
                var anio_a = moment().format("YYYY");
                $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre',
                    'Octubre', 'Noviembre', 'Diciembre'
                ]
                $('#mes').empty();
                $('#mes').append('<option value="">Mes</option>')
                if ($anio >= anio_a) {
                    for (let index = 0; index < new Date().getMonth() + 1; index++) {
                        $('#mes').append("<option value='" + (index + 1) + "'>" + $meses[index] + "</option>");
                    }
                } else {
                    for (let index = 0; index < 12; index++) {
                        $('#mes').append("<option value='" + (index + 1) + "'>" + $meses[index] + "</option>");
                    }
                }
                $meses_mn = [];
                $.ajax({
                    url: "{{ url('api/mercados') }}",
                    type: 'GET',
                    data: {
                        "mercado": $('#mercado').val(),
                        "anio": $('#anio').val()
                    },
                    dataType: 'json',
                    success: function(response) {
                        $.each(response.data, function(key, value) {
                            $meses_mn[key] = value.cuenta
                        });
                        datos_meses($meses_mn);
                    },
                    error: function() {
                        alert('Hubo un error obteniendo las ciudades!');
                    }
                });
                $estados = [];
                $.ajax({
                    url: "{{ url('api/estados') }}",
                    type: 'GET',
                    data: {
                        "mes": $('#mes').val(),
                        "mercado": $('#mercado').val(),
                        "anio": $('#anio').val()
                    },
                    dataType: 'json',
                    success: function(response) {
                        var colores = [];
                        $.each(response.data, function(key, value) {
                            $estados[key] = {
                                'name': value.name,
                                'y': value.cuenta
                            }
                            var brightness = 0.1;
                            colores.push(value.color);
                        });
                        Highcharts.getOptions().colors = Highcharts.map(colores, function(color) {
                            return {
                                radialGradient: {
                                    cx: 0.5,
                                    cy: 0.3,
                                    r: 0.7
                                },
                                stops: [
                                    [0, color],
                                    [1, Highcharts.Color(color).brighten(-0.3).get(
                                        'rgb')] // darken
                                ]
                            };
                        });
                        dato_estados($estados);
                    },
                    error: function() {
                        alert('Hubo un error obteniendo dato de los estados! ' + $('#mercado').val());
                    }
                });
                $productos_m = [0, 0, 0, 0, 0, 0, 0];
                $productos_ap = [0, 0, 0, 0, 0, 0, 0];

                $.ajax({
                    url: "{{ url('api/productos_m') }}",
                    type: 'GET',
                    data: {
                        "mes": $('#mes').val(),
                        "mercado": $('#mercado').val(),
                        "anio": $('#anio').val()
                    },
                    dataType: 'json',
                    success: function(response) {
                        $.each(response.data, function(key, value) {
                            switch (value.producto) {
                                case 'Bodegaje':
                                    $productos_m[0] = {
                                        'name': value.producto,
                                        'y': value.Solicitadas
                                    }
                                    $productos_ap[0] = {
                                        'name': value.producto,
                                        'y': value.Aprobadas
                                    }
                                    break;
                                case 'Carga Diplomatica':
                                    $productos_m[1] = {
                                        'name': value.producto,
                                        'y': value.Solicitadas
                                    }
                                    $productos_ap[1] = {
                                        'name': value.producto,
                                        'y': value.Aprobadas
                                    }
                                    break;
                                case 'Licitaciones':
                                    $productos_m[2] = {
                                        'name': value.producto,
                                        'y': value.Solicitadas
                                    }
                                    $productos_ap[2] = {
                                        'name': value.producto,
                                        'y': value.Aprobadas
                                    }
                                    break;
                                case 'Mascota':
                                    $productos_m[3] = {
                                        'name': value.producto,
                                        'y': value.Solicitadas
                                    }
                                    $productos_ap[3] = {
                                        'name': value.producto,
                                        'y': value.Aprobadas
                                    }
                                    break;
                                case 'Menaje':
                                    $productos_m[4] = {
                                        'name': value.producto,
                                        'y': value.Solicitadas
                                    }
                                    $productos_ap[4] = {
                                        'name': value.producto,
                                        'y': value.Aprobadas
                                    }
                                    break;
                                case 'Nacionalizacion':
                                    $productos_m[5] = {
                                        'name': value.producto,
                                        'y': value.Solicitadas
                                    }
                                    $productos_ap[5] = {
                                        'name': value.producto,
                                        'y': value.Aprobadas
                                    }
                                    break;
                                case 'Obra de Arte':
                                    $productos_m[6] = {
                                        'name': value.producto,
                                        'y': value.Solicitadas
                                    }
                                    $productos_ap[6] = {
                                        'name': value.producto,
                                        'y': value.Aprobadas
                                    }
                                    break;
                                case 'Vehiculo':
                                    $productos_m[7] = {
                                        'name': value.producto,
                                        'y': value.Solicitadas
                                    }
                                    $productos_ap[7] = {
                                        'name': value.producto,
                                        'y': value.Aprobadas
                                    }
                                    break;
                            }
                        });
                        datos_productos($productos_m, $productos_ap);
                    },
                    error: function() {
                        alert('Hubo un error obteniendo dato de los estados!');
                    }
                });

                $operaciones_m = [0, 0, 0, 0, 0];
                $operaciones_ap = [0, 0, 0, 0, 0];

                $.ajax({
                    url: "{{ url('api/operaciones_m') }}",
                    type: 'GET',
                    data: {
                        "mes": $('#mes').val(),
                        "mercado": $('#mercado').val(),
                        "anio": $('#anio').val()
                    },
                    dataType: 'json',
                    success: function(response) {
                        $.each(response.data, function(key, value) {
                            switch (value.tipooperacion) {
                                case 'Exportación':
                                    $operaciones_m[0] = {
                                        'name': value.tipooperacion,
                                        'y': value.Solicitadas
                                    };
                                    $operaciones_ap[0] = {
                                        'name': value.tipooperacion,
                                        'y': value.Aprobadas
                                    }
                                    break;
                                case 'Importación':
                                    $operaciones_m[1] = {
                                        'name': value.tipooperacion,
                                        'y': value.Solicitadas
                                    };
                                    $operaciones_ap[1] = {
                                        'name': value.tipooperacion,
                                        'y': value.Aprobadas
                                    }
                                    break;
                                case 'Liberación de Guia':
                                    $operaciones_m[2] = {
                                        'name': value.tipooperacion,
                                        'y': value.Solicitadas
                                    };
                                    $operaciones_ap[2] = {
                                        'name': value.tipooperacion,
                                        'y': value.Aprobadas
                                    }
                                    break;
                                case 'Nacional/Local':
                                    $operaciones_m[3] = {
                                        'name': value.tipooperacion,
                                        'y': value.Solicitadas
                                    };
                                    $operaciones_ap[3] = {
                                        'name': value.tipooperacion,
                                        'y': value.Aprobadas
                                    }
                                    break;
                                case 'Traspaso':
                                    $operaciones_m[4] = {
                                        'name': value.tipooperacion,
                                        'y': value.Solicitadas
                                    };
                                    $operaciones_ap[4] = {
                                        'name': value.tipooperacion,
                                        'y': value.Aprobadas
                                    }
                                    break;
                            }
                        });
                        datos_operaciones($operaciones_m, $operaciones_ap);
                    },
                    error: function() {
                        alert('Hubo un error obteniendo dato de los estados!');
                    }
                });
                $paises_l = [];
                $paises_sl = [];
                $paises_ap = [];

                $('#tabla_paises > tbody').empty();
                $.ajax({
                    url: "{{ url('api/paises_sl') }}",
                    type: 'GET',
                    data: {
                        "mes": $('#mes').val(),
                        "mercado": $('#mercado').val(),
                        "anio": $('#anio').val()
                    },
                    dataType: 'json',
                    success: function(response) {
                        $.each(response.data, function(key, value) {
                            $('#tabla_paises').append('<tr><td>' + value.pais +
                                '</td>' +
                                '<td class="center">' + value.Solicitadas + '</td>' +
                                '<td class="center">' + value.Aprobadas + '</td></tr>');
                            $paises_sl[key] = {
                                'name': value.pais,
                                'y': value.Solicitadas
                            };
                            $paises_ap[key] = {
                                'name': value.pais,
                                'y': value.Aprobadas
                            };
                            $paises_l[key] = value.pais
                        });
                        datos_paises($paises_sl, $paises_ap, $paises_l);
                    },
                    error: function() {
                        alert('Hubo un error obteniendo dato de los paises solicitados!');
                    }
                });


                $agentes_l = [];
                $agentes_sl = [];
                $agentes_ap = [];

                $('#tabla_agentes > tbody').empty();
                $.ajax({
                    url: "{{ url('api/agentes_c') }}",
                    type: 'GET',
                    data: {
                        "mes": $('#mes').val(),
                        "mercado": $('#mercado').val(),
                        "anio": $('#anio').val()
                    },
                    dataType: 'json',
                    success: function(response) {
                        $.each(response.data, function(key, value) {
                            $('#tabla_agentes').append('<tr><td>' + value.razon_social + '</td>' +
                                '<td class="center">' + value.Solicitadas + '</td>' +
                                '<td class="center">' + value.Aprobadas + '</td></tr>');
                            $agentes_sl[key] = {
                                'name': value.razon_social,
                                'y': value.Solicitadas
                            };
                            $agentes_ap[key] = {
                                'name': value.razon_social,
                                'y': value.Aprobadas
                            };
                            $agentes_l[key] = value.razon_social
                        });
                        datos_agentes($agentes_sl, $agentes_ap, $agentes_l);
                    },
                    error: function() {
                        alert('Hubo un error obteniendo dato de los paises solicitados!');
                    }
                });
            });
        </script>
        <script src="{{ asset('assets/js/dashboard.js') }}" type="text/javascript"></script>
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
                                <strong>Dashboard</strong>
                            </h3>
                            <div class="widget-toolbar widget-toolbar-dark">
                                <div class="row">
                                    <div class="col-sm-5">
                                        <select style="width: 100%;" id="mercado" name="mercado">
                                            <option value=""><b>Tipo Cotización</b></option>
                                            <option value="consecutivo_mn">Mercado Natural</option>
                                            <option value="consecutivo_expo">Agente Exportación</option>
                                            <option value="consecutivo_impo">Agente Importación</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-4">

                                        <select style="width: 100%;" id="mes" name="mes" required>
                                            <option value="">Mes</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">

                                        <select style="width: 100%;" id="anio" name="anio" required>
                                            <option value="2021">2021</option>
                                            <option value="2022" selected>2022</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /section:custom/widget-box.options.collapsed -->
                        <div class="widget-body">
                            <div class="widget-main">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div id="cotizacion_meses"></div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div id="cotizacion_estados_mn"></div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div id="cotizacion_productos"></div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div id="cotizacion_operaciones"></div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-4">
                                        <table id="tabla_paises" class="table text-nowrap table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th class="center"
                                                        style="background-color: rgb(54, 122, 70);color: rgb(255, 255, 255);">
                                                        Pais</th>
                                                    <th class="center"
                                                        style="background-color: rgb(54, 122, 70);color: rgb(255, 255, 255);">
                                                        Solicitadas</th>
                                                    <th class="center"
                                                        style="background-color: rgb(54, 122, 70);color: rgb(255, 255, 255);">
                                                        Aprobadas</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                    <div class="col-md-8">
                                        <div id="PaisesT"></div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-7">
                                        <div id="AgentesT"></div>
                                    </div>
                                    <div class="col-md-5">
                                        <table id="tabla_agentes" class="table text-nowrap table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th class="center"
                                                        style="background-color: rgb(54, 122, 70);color: rgb(255, 255, 255);">
                                                        Agente</th>
                                                    <th class="center"
                                                        style="background-color: rgb(54, 122, 70);color: rgb(255, 255, 255);">
                                                        Solicitadas</th>
                                                    <th class="center"
                                                        style="background-color: rgb(54, 122, 70);color: rgb(255, 255, 255);">
                                                        Aprobadas</th>
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
    </div>
@endsection
