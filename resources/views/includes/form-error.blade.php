@if ($errors -> any())
<div class="alert alert-danger alert-dismissible"  data-auto-dismiss="3000" >
    <button type="button" class="close" data-dismiss="alert"aria-hidden="true">&times;</button>
    <h5><i class="icon fas fa-ban"></i>Error en el Formulario</h5>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{$error}}</li>
        @endforeach
    </ul>
</div>
@endif