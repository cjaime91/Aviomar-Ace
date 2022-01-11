function datos_meses(meses) {
    Highcharts.chart('cotizacion_meses', {
        title: {
            text: 'Cotizaciones Realizadas 2021'
        },
        subtitle: {
            text: 'Por Meses'
        },
        xAxis: {
            title: {
                text: 'Meses'
            },
            categories: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre']
        },
        yAxis: {
            title: {
                text: 'Numero de Cotizaciones'
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle'
        },
        plotOptions: {
            area: {
                fillColor: {
                    linearGradient: {
                        x1: 0,
                        y1: 0,
                        x2: 0,
                        y2: 1
                    },
                    stops: [
                        [0, '#3E5AB8'],
                        [1, '#ffffff']
                    ]
                }
            },
            series: {
                allowsPointSelect: true,
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y}'
                }
            }
        },
        series: [{
            type: 'area',
            colorByPoint: true,
            name: 'Cotizaciones',
            data: meses,
            showInLegend: false
        }],
        responsive: {
            rules: [{
                condition: {
                    maxWidth: 500
                },
                chartOption: {
                    legend: {
                        layout: 'horizontal',
                        align: 'center',
                        verticalAlign: 'bottom'
                    }
                }
            }]
        }
    })
}

function dato_estados(mes) {
    Highcharts.chart('cotizacion_estados_mn', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: 'Cotizaciones por Estado'
        },
        tooltip: {
            pointFormat: 'Cotizaciones:{point.y}(<b>{point.percentage:.1f}%</b>)'
        },
        accessibility: {
            point: {
                valueSuffix: '%'
            }
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    connectorColor: 'silver'
                }
            }
        },
        series: [{
            type: 'pie',
            data: mes
        }],
        responsive: {
            rules: [{
                condition: {
                    maxWidth: 500
                },
                chartOption: {
                    legend: {
                        layout: 'horizontal',
                        align: 'center',
                        verticalAlign: 'bottom'
                    }
                }
            }]
        }
    });
}

function datos_productos(productos_m, productos_ap) {
    var productos = Highcharts.chart('cotizacion_productos', {
        chart: {
            type: 'column',
            inverted: true,
            options3d: {
                enabled: true,
                alpha: 0,
                beta: 36,
                depth: 100,
                viewDistance: 25
            },
            height: 550
        },
        title: {
            text: 'Cotizaciones por Productos'
        },
        subtitle: {
            text: 'Solicitadas VS Aprobadas'
        },
        xAxis: {
            title: {
                text: 'Productos'
            },
            categories: ['Bodegaje', 'Carga Diplomatica', 'Licitaciones', 'Mascota', 'Menaje', 'Nacionalización', 'Obra de Arte', 'Vehiculo'],
        },
        yAxis: {
            title: {
                text: 'Numero de Cotizaciones'
            }
        },
        plotOptions: {
            series: {
                allowsPointSelect: true,
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y}'
                }
            }
        },
        series: [{
            name: 'Solicitadas',
            data: productos_m,
            color: 'rgb(255, 127, 68)'
        }, {
            name: 'Aprobadas',
            data: productos_ap,
            color: 'rgb(150, 255, 25)'
        }],
        responsive: {
            rules: [{
                condition: {
                    maxWidth: 500
                },
                chartOption: {
                    legend: {
                        layout: 'horizontal',
                        align: 'center',
                        verticalAlign: 'bottom'
                    }
                }
            }]
        }
    })
}

function datos_operaciones(operaciones_m, operaciones_ap) {
    const operaciones = Highcharts.chart('cotizacion_operaciones', {
        chart: {
            type: 'column',
            options3d: {
                enabled: true,
                alpha: 0,
                beta: 36,
                depth: 100,
                viewDistance: 25
            },
            height: 550
        },
        title: {
            text: 'Cotizaciones por Operaciones'
        },
        subtitle: {
            text: 'Solicitadas VS Aprobadas'
        },
        xAxis: {
            title: {
                text: 'Operación'
            },
            categories: ['Exportación', 'Importación', 'Liberación de Guia', 'Nacional/Local', 'Traspaso'],
        },
        yAxis: {
            title: {
                text: 'Numero de Cotizaciones'
            }
        },
        plotOptions: {
            series: {
                allowsPointSelect: true,
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y}'
                }
            }
        },
        series: [{
            name: 'Solicitadas',
            data: operaciones_m,
            color: 'rgb(215, 55, 38)'
        }, {
            name: 'Aprobadas',
            data: operaciones_ap,
            color: 'rgb(0, 102, 180)'
        }],
        responsive: {
            rules: [{
                condition: {
                    maxWidth: 500
                },
                chartOption: {
                    legend: {
                        layout: 'horizontal',
                        align: 'center',
                        verticalAlign: 'bottom'
                    }
                }
            }]
        }
    })
}

function datos_paises(paises_sl, paises_ap, paises_l) {
    Highcharts.chart('PaisesT', {
        chart: {
            type: 'column',
            height: 550
        },
        title: {
            text: 'Cotizaciones por Paises'
        },
        subtitle: {
            text: 'Solicitadas VS Aprobadas'
        },
        xAxis: {
            title: {
                text: 'Paises'
            },
            categories: paises_l,
        },
        yAxis: {
            title: {
                text: 'Numero de Cotizaciones'
            }
        },
        plotOptions: {
            series: {
                allowsPointSelect: true,
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y}'
                }
            }
        },
        series: [{
            name: 'Solicitadas',
            data: paises_sl,
            color: 'rgb(211, 101, 14)'
        }, {
            name: 'Aprobadas',
            data: paises_ap,
            color: 'rgb(70, 194, 8)'
        }],
        responsive: {
            rules: [{
                condition: {
                    maxWidth: 500
                },
                chartOption: {
                    legend: {
                        layout: 'horizontal',
                        align: 'center',
                        verticalAlign: 'bottom'
                    }
                }
            }]
        }
    })
}

function datos_agentes(agentes_sl, agentes_ap, agentes_l) {
    Highcharts.chart('AgentesT', {
        chart: {
            type: 'column',
            inverted: true,
            height: 750
        },
        title: {
            text: 'Cotizaciones por Agentes'
        },
        subtitle: {
            text: 'Solicitadas VS Aprobadas'
        },
        xAxis: {
            title: {
                text: 'Agentes'
            },
            categories: agentes_l,
        },
        yAxis: {
            title: {
                text: 'Numero de Cotizaciones'
            }
        },
        plotOptions: {
            series: {
                allowsPointSelect: true,
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y}'
                }
            }
        },
        series: [{
            name: 'Solicitadas',
            data: agentes_sl,
            color: 'rgb(215, 55, 38)'
        }, {
            name: 'Aprobadas',
            data: agentes_ap,
            color: 'rgb(0, 102, 180)'
        }],
        responsive: {
            rules: [{
                condition: {
                    maxWidth: 500
                },
                chartOption: {
                    legend: {
                        layout: 'horizontal',
                        align: 'center',
                        verticalAlign: 'bottom'
                    }
                }
            }]
        }
    })
}

$(document).ready(function() {
    $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre',
        'Noviembre', 'Diciembre'
    ]
    for (let index = 0; index < new Date().getMonth() + 1; index++) {
        $('#mes').append("<option value='" + (index + 1) + "'>" + $meses[index] + "</option>");
    }

    // scrollables
    $('.scrollable').each(function() {
        var $this = $(this);
        $(this).ace_scroll({
            size: $this.attr('data-size') || 100,
            //styleClass: 'scroll-left scroll-margin scroll-thin scroll-dark scroll-light no-track scroll-visible'
        });
    });
    $('.scrollable-horizontal').each(function() {
        var $this = $(this);
        $(this).ace_scroll({
            horizontal: true,
            styleClass: 'scroll-top', //show the scrollbars on top(default is bottom)
            size: $this.attr('data-size') || 500,
            mouseWheelLock: true
        }).css({ 'padding-top': 12 });
    });

    $(window).on('resize.scroll_reset', function() {
        $('.scrollable-horizontal').ace_scroll('reset');
    });


    $('#id-checkbox-vertical').prop('checked', false).on('click', function() {
        $('#widget-toolbox-1').toggleClass('toolbox-vertical')
            .find('.btn-group').toggleClass('btn-group-vertical')
            .filter(':first').toggleClass('hidden')
            .parent().toggleClass('btn-toolbar')
    });
});