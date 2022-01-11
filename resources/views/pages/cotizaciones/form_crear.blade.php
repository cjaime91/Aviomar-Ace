<div class="row">
    <div class="col-sm-4">
        <div class="form-group row">
            <label class="col-sm-4 col-form-label"><b>Tipo Cotización</b></label>
            <div class="col-sm-7">
                <select class="form-control input-sm" style="width: 100%;" id="tcotizacion" name="tcotizacion" required>
                    <option value="">--Seleccione--</option>
                    <option value="1">Mercado Natural</option>
                    <option value="2">Agente Exportación</option>
                    <option value="3">Agente Importación</option>
                </select>
            </div>
        </div>
    </div>

    <div class="col-sm-1">
    </div>
    <div class="col-sm-3">
        <div class="form-group row">
            <label class="col-sm-3"><b>Fecha</b></label>
            <div class="col-sm-7">
                <input type="date" id="fecha" name="fecha" class="form-control center input-sm"
                    placeholder="dd/mm/yyyy" />
            </div>
        </div>
    </div>
    <div class="col-sm-2">
    </div>
    <div class="col-sm-2">
        <div class="form-group row">
            <label class="col-sm-8"><b># Referencia</b></label>
            <div class="col-sm-4">
                <input type="text" class="form-control text-center input-sm" id="num_ref" name="num_ref" placeholder="#"
                    maxlength="9" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;"
                    required data-readonly>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-8">
        <div class="form-group row">
            <label class="col-sm-2"><b>Controlador</b></label>
            <div class="col-sm-10">
                <select class="form-control input-sm" style="width: 100%;" id="agente_id_c" name="agente_id_c" required>
                    <option value="">--Seleccione--</option>
                    @foreach ($agentes as $agente)
                        <option value="{{ $agente->agente_id }}">{{ $agente->razon_social }} ({{ $agente->ciudad }},
                            {{ $agente->pais }}) | {{ $agente->codigo }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="col-sm-4">
        <div class="form-group">
            <label class="col-sm-4"><b>Ejecutivo</b></label>
            <div class="col-sm-8">
                <select class="form-control chosen-select input-sm" id="usuario_ejecutivo_id"
                    name="usuario_ejecutivo_id" style="width: 100%;" required>
                    <option value="">--Seleccione--</option>
                    @foreach ($users_ej as $user)
                        <option value="{{ $user->id }}">{{ $user->full_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-8">
        <div class="form-group row">
            <label class="col-sm-2"><b>Agente Origen</b></label>
            <div class="col-sm-10">
                <select class="form-control input-sm" style="width: 100%;" id="agente_id_o" name="agente_id_o" required>
                    <option value="">--Seleccione--</option>
                    @foreach ($agentes as $agente)
                        <option value="{{ $agente->agente_id }}">{{ $agente->razon_social }} ({{ $agente->ciudad }},
                            {{ $agente->pais }}) | {{ $agente->codigo }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group row">
            <label class="col-sm-4"><b>Gastos Origen</b></label>
            <div class="col-sm-8">
                <div class="input-group">
                    <div class="input-group-addon">
                        <span class="input-group-text">$</span>
                    </div>
                    <input type="text" class="form-control text-right input-sm" placeholder="0" id="valor_o"
                        name="valor_o" maxlength="9"
                        onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;">
                    <div class="input-group-addon">
                        <span class="input-group-text">.00</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
</div>
<div class="row">
    <div class="col-sm-8">
        <div class="form-group row">
            <label class="col-sm-2"><b>Agente Destino</b></label>
            <div class="col-sm-10">
                <select class="form-control input-sm" style="width: 100%;" id="agente_id_d" name="agente_id_d" required>
                    <option value="">--Seleccione--</option>
                    @foreach ($agentes as $agente)
                        <option value="{{ $agente->agente_id }}">{{ $agente->razon_social }} ({{ $agente->ciudad }},
                            {{ $agente->pais }}) | {{ $agente->codigo }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group row">
            <label class="col-sm-4"><b>Gastos Destino</b></label>
            <div class="col-sm-8">
                <div class="input-group">
                    <div class="input-group-addon">
                        <span class="input-group-text">$</span>
                    </div>
                    <input type="text" class="form-control text-right input-sm" placeholder="0" id="valor_d"
                        name="valor_d" maxlength="9"
                        onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;">
                    <div class="input-group-addon">
                        <span class="input-group-text">.00</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-8">
        <div class="form-group row">
            <label class="col-sm-2"><b>Cliente</b></label>
            <div class="col-sm-10">
                <input type="text" class="form-control input-sm" placeholder="" id="cliente" name="cliente" required>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group row">
            <label class="col-sm-4"><b>Sucursal</b></label>
            <div class="col-sm-8">
                <select class="form-control input-sm" style="width: 100%;" id="sucursal_id" name="sucursal_id" required>
                    <option value="">--Seleccione--</option>
                    @foreach ($sucursales as $sucursal)
                        <option value="{{ $sucursal->sucursal_id }}">{{ $sucursal->sucursal }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-8">
        <div class="form-group row">
            <label for="fname" class="col-sm-2"><b>Empresa</b></label>
            <div class="col-sm-10">
                <input type="text" class="form-control input-sm" id="fname" placeholder="" id="empresa" name="empresa">
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group row">
            <label class="col-sm-4"><b>Facturar a</b></label>
            <div class="col-sm-8">
                <select class="form-control input-sm" style="width: 100%;" id="facturar_a" name="facturar_a" required>
                    <option value="">--Seleccione--</option>
                    <option Value="Agente">Agente</option>
                    <option Value="Cliente">Cliente</option>
                    <option Value="Empresa Cliente">Empresa Cliente</option>
                    <option Value="Cortesia">Cortesia</option>
                </select>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
    </div>
</div>
<div class="row">
    <div class="col-sm-4">
        <div class="form-group row">
            <label class="col-sm-4"><b>Operación</b></label>
            <div class="col-sm-8">
                <select class="form-control input-sm" style="width: 100%;" id="toper_id" name="toper_id" required>
                    <option value="">--Seleccione--</option>
                    @foreach ($tipooperaciones as $tipooperacion)
                        <option value="{{ $tipooperacion->toper_id }}">{{ $tipooperacion->tipooperacion }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group row">
            <label class="col-sm-4"><b>Tipo Cliente</b></label>
            <div class="col-sm-8">
                <select class="form-control input-sm" style="width: 100%;" id="tcliente_id" name="tcliente_id" required>
                    <option value="">--Seleccione--</option>
                    @foreach ($tipoclientes as $tipocliente)
                        <option value="{{ $tipocliente->tcliente_id }}">{{ $tipocliente->tipocliente }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group row">
            <label class="col-sm-4"><b>Producto</b></label>
            <div class="col-sm-8">
                <select class="form-control input-sm" style="width: 100%;" id="producto_id" name="producto_id" required>
                    <option value="">--Seleccione--</option>
                    @foreach ($productos as $producto)
                        <option value="{{ $producto->producto_id }}">{{ $producto->producto }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-4">
        <div class="form-group row">
            <label class="col-sm-4"><b>Transporte</b></label>
            <div class="col-sm-8">
                <select class="form-control input-sm" style="width: 100%;" id="ttrans_id" name="ttrans_id" required>
                    <option value="">--Seleccione--</option>
                    @foreach ($tipotransportes as $tipotransportes)
                        <option value="{{ $tipotransportes->ttrans_id }}">{{ $tipotransportes->tipotransporte }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group row" id="dis_cbm">
            <label for="cbm" class="col-sm-4"><b>CBM</b></label>
            <div class="col-sm-8">
                <input type="text" class="form-control input-sm" id="cbm" name="cbm" maxlength="9"
                    onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;">
            </div>
        </div>
        <div class="form-group row" id="dis_am" style="display: none;">
            <label for="cbm_a" class="col-sm-3"><b>CBM A</b></label>
            <div class="col-sm-3">
                <input type="text" class="form-control input-sm" id="cbm_a" name="cbm_a" maxlength="9"
                    onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;">
            </div>
            <label for="cbm_a" class="col-sm-3"><b>Libras
                    A</b></label>
            <div class="col-sm-3">
                <input type="text" class="form-control input-sm" id="libras_a" name="libras_a" maxlength="9"
                    onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" readonly>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group row" id="lib_cbm">
            <label for="libras" class="col-sm-4"><b>Libras</b></label>
            <div class="col-sm-8">
                <input type="text" class="form-control input-sm" id="libras" name="libras" readonly>
            </div>
        </div>
        <div class="form-group row" id="lib_am" style="display: none;">
            <label for="cbm_m" class="col-sm-3"><b>CBM M</b></label>
            <div class="col-sm-3">
                <input type="text" class="form-control input-sm" id="cbm_m" name="cbm_m" maxlength="9">
            </div>
            <label for="cbm_m" class="col-sm-3"><b>Libras
                    M</b></label>
            <div class="col-sm-3">
                <input type="text" class="form-control input-sm" id="libras_m" name="libras_m"
                    onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" readonly>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-3">
        <div class="form-group row">
            <label class="col-sm-5"><b>Pais Origen</b></label>
            <div class="col-sm-7">
                <select id="cod_pais_or" name="cod_pais_or" class="form-control input-sm" required>
                    <option value="">--Seleccione--</option>
                </select>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group row">
            <label class="col-sm-5"><b>Ciudad Origen</b></label>
            <div class="col-sm-7">
                <select id="ciudad_id_or" name="ciudad_id_or" class="form-control input-sm" required>
                    <option value="">--Seleccione--</option>
                </select>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group row">
            <label class="col-sm-5"><b>Pais Dest.</b></label>
            <div class="col-sm-7">
                <select id="cod_pais_ds" name="cod_pais_ds" class="form-control input-sm" required>
                    <option value="">--Seleccione--</option>
                </select>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group row">
            <label class="col-sm-5"><b>Ciudad Dest.</b></label>
            <div class="col-sm-7">
                <select id="ciudad_id_ds" name="ciudad_id_ds" class="form-control input-sm" required>
                    <option value="">--Seleccione--</option>
                </select>
            </div>
        </div>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-sm-3">
    </div>
    <div class="col-sm-2">
        <button type="reset" class="col-sm-12 btn btn-lg btn-warning btn-round">
            <i class="ace-icon fa fa-times white"></i>
            <b>Limpiar</b>
        </button>
    </div>
    <div class="col-sm-1">
    </div>
    <div class="col-sm-1">
    </div>
    <div class="col-sm-2">
        <button type="submit" class="col-sm-12 btn btn-lg btn-success btn-round">
            <i class="ace-icon fa fa-check"></i>
            <b>Crear</b>
        </button>
    </div>
    <div class="col-sm-1">
    </div>
</div>
