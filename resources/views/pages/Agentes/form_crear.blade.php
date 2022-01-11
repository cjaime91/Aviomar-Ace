<form>
    <div class="row">
        <div class="col-lg-4">
            <div class="form-group row">
                <label for="agente" class="col-sm-3 text-end control-label col-form-label"># Agente</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control input-sm" id="codigo" name="codigo" placeholder="Codigo Agente"
                        value="{{old('codigo')}}" required>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="form-group row">
                <label for="rz" class="col-sm-2 text-end control-label col-form-label">Razon Social</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control input-sm" id="razon_social" name="razon_social"
                        placeholder="Razon Social" value="{{old('razon_social')}}"
                        required>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="form-group row">
                <label for="direccion" class="col-sm-2 text-end control-label col-form-label">Dirección</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control input-sm" id="direccion" name="direccion" placeholder="Dirección"
                        value="{{old('direccion')}}">
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group row">
                <label for="email" class="col-sm-2 text-end control-label col-form-label">Email</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control input-sm" id="email" name="email" placeholder="Email"
                        value="{{old('email')}}">
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3">
            <div class="form-group row">
                <label class="col-sm-4 text-end control-label col-form-label">Pais</label>
                <div class="col-sm-8">
                    <select id="cod_pais" name="cod_pais" class="form-control select2bs4" required>
                        <option value="">--Seleccione--</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-lg-1">
        </div>
        <div class="col-md-3">
            <div class="form-group row">
                <label class="col-sm-4 text-end control-label col-form-label">Ciudad</label>
                <div class="col-md-8">
                    <select id="ciudad_id" name="ciudad_id" class="form-control select2bs4" required>
                        <option value="">--Seleccione--</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-lg-1">
        </div>
        <div class="col-md-4">
            <div class="form-group row">
                <label class="col-sm-3 text-end control-label col-form-label">Estado</label>
                <div class="col-sm-9">
                    <select id="estado_id" name="estado_id" class="form-control select2bs4" required>
                        <option value="">--Seleccione--</option>
                        @foreach ($estados as $estado)
                        <option value="{{$estado->estado_id}}"
                            {{old('estado_id')}}>
                            {{$estado->estado}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <div class="form-group row">
                <label for="telefono" class="col-sm-3 text-end control-label col-form-label">Telefono</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control input-sm" id="telefono" name="telefono" placeholder="Telefono"
                        value="{{old('telefono')}}">
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group row">
                <label for="celular" class="col-sm-3 text-end control-label col-form-label">Celular</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control input-sm" id="celular" name="celular" placeholder="Celular"
                        value="{{old('celular')}}">
                </div>
            </div>
        </div>
    </div>
    <br>
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
</form>