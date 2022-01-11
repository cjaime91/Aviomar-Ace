@if (session("estado18"))
<div id="modal-alert" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="widget-box widget-color-dark light-border" id="widget-box-6">
            <div class="widget-container-col ui-sortable" id="widget-container-col-5">
                <div class="widget-box ui-sortable-handle" id="widget-box-5">
                    <div class="widget-body">
                        <div class="widget-main padding-6">
                            <div class="alert alert-danger center">
                                <h2>Cotizacion <b>{{session("estado18")}}</b>Rechazada por mala Asesoria de la comercial</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif