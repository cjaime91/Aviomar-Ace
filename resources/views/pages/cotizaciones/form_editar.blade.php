<form action="{{route('actualizar_cotizacion',['id'=>$cotizacion->cot_id])}}" id="form-general"
    class="form-horizontal" method="POST" autocomplete="off">
    @csrf 
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group row">
                <label class="col-sm-4 col-form-label"><b>Tipo Cotización</b></label>
                <div class="col-sm-7">
                    <select class="form-control select2bs4 input-sm" style="width: 100%;" id="tcotizacion"
                        name="tcotizacion" required>
                        <option value="1" {{old('tcotizacion', $cotizacion->consecutivo_mn)!="" ?'selected': ''}}>
                            Mercado Natural</option>
                        <option value="2" {{old('tcotizacion', $cotizacion->consecutivo_expo)!="" ?'selected': ''}}>
                            Agente Exportación</option>
                        <option value="3" {{old('tcotizacion', $cotizacion->consecutivo_impo)!="" ?'selected': ''}}>
                            Agente Importación</option>
                    </select>
                </div>  
            </div>
        </div>
    
        <div class="col-sm-1">
        </div>
        <div class="col-sm-3">
            <div class="form-group row">
                <label class="col-sm-3 "><b>Fecha</b></label>
                <div class="col-sm-7">
                    <input type="date" id="fecha" name="fecha" class="form-control center input-sm" placeholder="dd/mm/yyyy"
                        value="{{old('fecha', $cotizacion->fecha ?? '')}}" />
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
                        value="{{old('num_ref', $cotizacion->num_ref ?? '')}}"  data-readonl required>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-sm-8">
            <div class="form-group row">
                <label class="col-sm-2"><b>Controlador</b></label>
                <div class="col-sm-10">
                    <select class="form-control select2bs4 input-sm" style="width: 100%;" id="agente_id_c"
                        name="agente_id_c" required>
                        <option value="">--Seleccione--</option>
                        @foreach ($agentes as $agente)
                        <option value="{{$agente->agente_id}}"
                            {{old('usuario_ejecutivo_id', $agente->agente_id)==$cotizacion->agente_id_c ?'selected': ''}}>
                            {{$agente->full_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    
        <div class="col-sm-4">
            <div class="form-group">
                <label class="col-sm-4"><b>Ejecutivo</b></label>
                <div class="col-sm-8">
                    <select class="form-control chosen-select select2bs4 input-sm" id="usuario_ejecutivo_id"
                        name="usuario_ejecutivo_id" style="width: 100%;" required>
                        <option value="">--Seleccione--</option>
                        @foreach ($users as $user)
                        <option value="{{$user->id}}"
                            {{old('usuario_ejecutivo_id', $user->id)==$cotizacion->usuario_ejecutivo_id ?'selected': ''}}>
                            {{$user->full_name}}</option>
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
                    <select class="form-control select2bs4 input-sm" style="width: 100%;" id="agente_id_o"
                        name="agente_id_o" required>
                        <option value="">--Seleccione--</option>
                        @foreach ($agentes as $agente)
                        <option value="{{$agente->agente_id}}"
                            {{old('usuario_ejecutivo_id', $agente->agente_id)==$cotizacion->agente_id_o ?'selected': ''}}>
                            {{$agente->full_name}}</option>
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
                        <input type="text" class="form-control text-right input-sm"
                            value="{{old('valor_o', $cotizacion->valor_o ?? '')}}" id="valor_o" name="valor_o">
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
                    <select class="form-control select2bs4 input-sm" style="width: 100%;" id="agente_id_d"
                        name="agente_id_d" required>
                        <option value="">--Seleccione--</option>
                        @foreach ($agentes as $agente)
                        <option value="{{$agente->agente_id}}"
                            {{old('usuario_ejecutivo_id', $agente->agente_id)==$cotizacion->agente_id_d ?'selected': ''}}>
                            {{$agente->full_name}}</option>
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
                        <input type="text" class="form-control text-right input-sm"
                            value="{{old('valor_d', $cotizacion->valor_d ?? '')}}" id="valor_d" name="valor_d">
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
                    <input type="text" class="form-control input-sm" placeholder="Cliente" id="cliente" name="cliente"
                        value="{{old('cliente', $cotizacion->cliente ?? '')}}" required>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group row">
                <label class="col-sm-4"><b>Sucursal</b></label>
                <div class="col-sm-8">
                    <select class="form-control select2bs4 input-sm" style="width: 100%;" id="sucursal_id"
                        name="sucursal_id" required>
                        <option value="">--Seleccione--</option>
                        @foreach ($sucursales as $sucursal)
                        <option value="{{$sucursal->sucursal_id}}"
                            {{old('usuario_ejecutivo_id', $sucursal->sucursal_id)==$cotizacion->sucursal_id ?'selected': ''}}>
                            {{$sucursal->sucursal}}</option>
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
                    <input type="text" class="form-control input-sm" id="fname" placeholder="Empresa" id="empresa"
                        value="{{old('empresa', $cotizacion->empresa ?? '')}}" name="empresa">
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group row">
                <label class="col-sm-4"><b>Facturar a</b></label>
                <div class="col-sm-8">
                    <select class="form-control select2bs4 input-sm" style="width: 100%;" id="facturar_a" name="facturar_a"
                        required>
                        <option value="">--Seleccione--</option>
                        <option Value="Agente" {{old('facturar_a', $cotizacion->facturar_a)=="Agente" ?'selected': ''}}>
                            Agente</option>
                        <option Value="Cliente" {{old('facturar_a', $cotizacion->facturar_a)=="Cliente" ?'selected': ''}}>
                            Cliente</option>
                        <option Value="Empresa Cliente"
                            {{old('facturar_a', $cotizacion->facturar_a)=="Empresa Cliente" ?'selected': ''}}>Empresa
                            Cliente</option>
                        <option Value="Cortesia" {{old('facturar_a', $cotizacion->facturar_a)=="Cortesia" ?'selected': ''}}>
                            Cortesia</option>
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
                    <select class="form-control select2bs4 input-sm" style="width: 100%;" id="toper_id" name="toper_id"
                        required>
                        <option value="">--Seleccione--</option>
                        @foreach ($tipooperaciones as $toper)
                        <option value="{{$toper->toper_id}}"
                            {{old('usuario_ejecutivo_id', $toper->toper_id)==$cotizacion->toper_id ?'selected': ''}}>
                            {{$toper->tipooperacion}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group row">
                <label class="col-sm-4"><b>Tipo Cliente</b></label>
                <div class="col-sm-8">
                    <select class="form-control select2bs4 input-sm" style="width: 100%;" id="tcliente_id"
                        name="tcliente_id" required>
                        <option value="">--Seleccione--</option>
                        @foreach ($tipoclientes as $tclient)
                        <option value="{{$tclient->tcliente_id}}"
                            {{old('usuario_ejecutivo_id', $tclient->tcliente_id)==$cotizacion->tcliente_id ?'selected': ''}}>
                            {{$tclient->tipocliente}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group row">
                <label class="col-sm-4"><b>Producto</b></label>
                <div class="col-sm-8">
                    <select class="form-control select2bs4 input-sm" style="width: 100%;" id="producto_id"
                        name="producto_id" required>
                        <option value="">--Seleccione--</option>
                        @foreach ($productos as $prodcuto)
                        <option value="{{$prodcuto->producto_id}}"
                            {{old('usuario_ejecutivo_id', $prodcuto->producto_id)==$cotizacion->producto_id ?'selected': ''}}>
                            {{$prodcuto->producto}}</option>
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
                    <select class="form-control select2bs4 input-sm" style="width: 100%;" id="ttrans_id" name="ttrans_id"
                        required>
                        <option value="">--Seleccione--</option>
                        @foreach ($tipotransportes as $ttrans)
                        <option value="{{$ttrans->ttrans_id}}"
                            {{old('usuario_ejecutivo_id', $ttrans->ttrans_id)==$cotizacion->ttrans_id ?'selected': ''}}>
                            {{$ttrans->tipotransporte}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group row" id="dis_cbm" @if ($cotizacion->cbm) style="display: visible;" @else style="display: none;" @endif >
                <label for="cbm" class="col-sm-4"><b>CBM</b></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control text-center input-sm" value="{{old('cbm', $cotizacion->cbm ?? '')}}" id="cbm"
                        name="cbm">
                </div>
            </div>
            <div class="form-group row" id="dis_am" @if ($cotizacion->cbm_a) style="display: visible;" @else style="display: none;" @endif>
                <label for="cbm_a" class="col-sm-3"><b>CBM A</b></label>
                <div class="col-sm-3">
                    <input type="text" class="form-control text-center input-sm" value="{{old('cbm_a', $cotizacion->cbm_a ?? '')}}"
                        id="cbm_a" name="cbm_a">
                </div>
                <label for="cbm_a" class="col-sm-3"><b>Libras
                        A</b></label>
                <div class="col-sm-3">
                    <input type="text" class="form-control text-center input-sm"
                        value="{{old('libras_a', $cotizacion->libras_a ?? '')}}" id="libras_a" name="libras_a" readonly>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group row" id="lib_cbm" @if ($cotizacion->cbm) style="display: visible;" @else style="display:
                none;" @endif >
                <label for="libras" class="col-sm-4"><b>Libras</b></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control text-center input-sm" value="{{old('libras', $cotizacion->libras ?? '')}}"
                        id="libras" name="libras" readonly>
                </div>
            </div>
            <div class="form-group row" id="lib_am" @if ($cotizacion->cbm_m) style="display: visible;" @else style="display:
                none;" @endif>
                <label for="cbm_m" class="col-sm-3 center"><b>CBM M</b></label>
                <div class="col-sm-3">
                    <input type="text" class="form-control text-center input-sm" value="{{old('cbm_m', $cotizacion->cbm_m ?? '')}}"
                        id="cbm_m" name="cbm_m">
                </div>
                <label for="cbm_m" class="col-sm-3"><b>Libras
                        M</b></label>
                <div class="col-sm-3">
                    <input type="text" class="form-control text-center input-sm"
                        value="{{old('libras_m', $cotizacion->libras_m ?? '')}}" id="libras_m" name="libras_m" readonly>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3">
            <div class="form-group row">
                <label class="col-sm-5"><b>Pais Origen</b></label>
                <div class="col-sm-7">
                    <select id="cod_pais_or" name="cod_pais_or" class="form-control select2bs4 input-sm" required>
                        <option value="">--Seleccione--</option>
                        @foreach ($paises as $pais)
                        <option value="{{$pais->cod}}"
                            {{old('cod_pais_or', $pais->cod)==$cotizacion->cod_pais_or ?'selected': ''}}>
                            {{$pais->pais}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group row">
                <label class="col-sm-5"><b>Ciudad Origen</b></label>
                <div class="col-sm-7">
                    <select id="ciudad_id_or" name="ciudad_id_or" class="form-control select2bs4 input-sm" required>
                        <option value="">--Seleccione--</option>
                        @foreach ($ciudad_or as $cor)
                        <option value="{{$cor->ciudad_id}}"
                            {{old('ciudad_id_or', $cor->ciudad_id)==$cotizacion->ciudad_id_or ?'selected': ''}}>
                            {{$cor->ciudad}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-group row">
                <label class="col-sm-5"><b>Pais Dest.</b></label>
                <div class="col-sm-7">
                    <select id="cod_pais_ds" name="cod_pais_ds" class="form-control select2bs4 input-sm" required>
                        <option value="">--Seleccione--</option>
                        @foreach ($paises as $pais)
                        <option value="{{$pais->cod}}"
                            {{old('cod_pais_ds', $pais->cod)==$cotizacion->cod_pais_ds ?'selected': ''}}>
                            {{$pais->pais}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group row">
                <label class="col-sm-5"><b>Ciudad Dest.</b></label>
                <div class="col-sm-7">
                    <select id="ciudad_id_ds" name="ciudad_id_ds" class="form-control select2bs4 input-sm" required>
                        <option value="">--Seleccione--</option>
                        @foreach ($ciudad_ds as $cor)
                        <option value="{{$cor->ciudad_id}}"
                            {{old('ciudad_id_ds', $cor->ciudad_id)==$cotizacion->ciudad_id_ds ?'selected': ''}}>
                            {{$cor->ciudad}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>{{--
    <div class="row">
    
        <div class="col-sm-8">
            <div class="form-group row">
                <label class="col-sm-2"><b>Consecutivo</b></label>
                <div class="col-sm-6">
                    <input type="text" class="form-control text-center input-sm" placeholder="0000" id="consecutivof"
                        name="consecutivo" readonly>
                </div>
            </div>
        </div>
        <input type="text" class="form-controltext-center input-sm" id="usuario_realiza_id" name="usuario_realiza_id"
            placeholder="#" value="{{auth()->user()->id}}" required>
    </div>--}}
    <hr>
    <div class="row">
        <div class="col-sm-5">
        </div>
        <div class="col-sm-2">
            <button type="submit" class="col-sm-12 btn btn-lg btn-success btn-round">
                <i class="ace-icon fa fa-check"></i>
                <b>Modificar</b>
            </button>
        </div>
        <div class="col-sm-5">
        </div>
    </div>
</form>