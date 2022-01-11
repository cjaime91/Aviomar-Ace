@if (session("alerta"))
<div id="modal-alert" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="widget-box widget-color-dark light-border" id="widget-box-6">
            <div class="widget-container-col ui-sortable" id="widget-container-col-5">
                <div class="widget-box ui-sortable-handle" id="widget-box-5">
                    <div class="widget-body">
                        <div class="widget-main padding-6">
                            <div class="alert alert-success center"> 
                                <p>
                                    <h2>Se ha creado la cotizacion</h2>
                                </p> 
                                <p>
                                    <h1>{{session("alerta")}}</h1>
                                </p>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif