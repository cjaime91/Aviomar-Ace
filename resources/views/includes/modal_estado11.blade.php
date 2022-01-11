@if (session("estado11"))
<div id="modal-alert" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="widget-box widget-color-dark light-border" id="widget-box-6">
            <div class="widget-container-col ui-sortable" id="widget-container-col-5">
                <div class="widget-box ui-sortable-handle" id="widget-box-5">
                    <div class="widget-body">
                        <div class="widget-main padding-6">
                            <div class="alert alert-warning center">
                                <h2>Cotizacion <b>{{session("estado11")}}</b> En espera de respuesta del agente</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif