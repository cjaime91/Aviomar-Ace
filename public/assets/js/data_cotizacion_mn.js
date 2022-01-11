$(document).ready(function () {
    var tabla_mn1 = $('#tcmn').DataTable();
    tabla_mn1.buttons().container().appendTo($('.tableTools-container'));

    $('#ope').select2(); 
    $('#tcli').select2(); 
    $('#prod').select2(); 
    $('#ejecutivo').select2();
    $('#realizado').select2();
    $('#est').select2();

    $('#ope').on('change', function () {
        if ($('#ope option:selected').text().replace(/(\r\n|\n|\r| )/g, '') == '---') {
            tabla_mn1
                .columns(3)
                .search("")
                .draw();
        } else {
            tabla_mn1
                .columns(3)
                .search($('#ope option:selected').text().replace(/(\r\n|\n|\r| )/g, ''))
                .draw();
        }
    });

    $('#tcli').on('change', function () {
        if ($('#tcli option:selected').text() == '---') {
            tabla_mn1
                .columns(4)
                .search("")
                .draw();
        } else {
            tabla_mn1
                .columns(4)
                .search($('#tcli option:selected').text())
                .draw();
        }
    });

    $('#prod').on('change', function () {
        if ($('#prod option:selected').text().replace(/(\r\n|\n|\r| )/g, '') == '---') {
            tabla_mn1
                .columns(5)
                .search("")
                .draw();
        } else {
            tabla_mn1
                .columns(5)
                .search($('#prod option:selected').text().replace(/(\r\n|\n|\r| )/g, ''))
                .draw();
        }
    });

    $('#ejecutivo').on('change', function () {
        if ($('#ejecutivo option:selected').text() == '---') {
            tabla_mn1
                .columns(6)
                .search("")
                .draw();
        } else {
            tabla_mn1
                .columns(6)
                .search($('#ejecutivo option:selected').text())
                .draw();
        }
    });

    $('#realizado').on('change', function () {
        if ($('#realizado option:selected').text() == '---') {
            tabla_mn1
                .columns(7)
                .search("")
                .draw();
        } else {
            tabla_mn1
                .columns(7)
                .search($('#realizado option:selected').text())
                .draw();
        }
    });

    $('#est').on('change', function () {
        if ($('#est option:selected').text().replace(/(\r\n|\n|\r| )/g, '') == '---') {
            tabla_mn1
                .columns(8)
                .search("")
                .draw();
        } else {
            tabla_mn1
                .columns(8)
                .search($('#est option:selected').text().replace(/(\r\n|\n|\r| )/g, ''))
                .draw();
        }
    });

    $('#cot_mn').on('keyup', function () {
        if ($('#cot_mn').val() == '') {
            tabla_mn1
                .columns(0)
                .search("")
                .draw();
        } else {
            tabla_mn1
                .columns(0)
                .search($('#cot_mn').val())
                .draw();
        }
    });

    $('#cliente').on('keyup', function () {
        if ($('#cliente').val() == '') {
            tabla_mn1
                .columns(1)
                .search("")
                .draw();
        } else {
            tabla_mn1
                .columns(1)
                .search($('#cliente').val())
                .draw();
        }
    });
})