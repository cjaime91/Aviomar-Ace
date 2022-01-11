$(document).ready(function() {
    var table1 = $('#tabla_agentes').DataTable();

    $('#codigo').on('keyup', function() {
        table1
            .columns(1)
            .search(this.value)
            .draw();
    });

    $('#agente').on('change', function () {
        if ($('#agente option:selected').val()== '---') {
            table1
                .columns(2)
                .search("")
                .draw();
        } else {
            table1
                .columns(2)
                .search($('#agente option:selected').val())
                .draw();
        }
    });

    $('#estado').on('change', function() {
        if ($('#estado option:selected').text() == '---') {
            table1
                .columns(5)
                .search("")
                .draw();
        } else {
            table1
                .columns(5)
                .search($('#estado option:selected').text())
                .draw();
        }
    });
})