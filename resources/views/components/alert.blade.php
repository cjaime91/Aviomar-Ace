<div class="alert alert-{{$tipo}} alert-dismissible" data-auto-dismiss="3000" role="alert">
    <h5 class="alert-heading"></i>Error</h5>
    <p>
        @if (is_object($mensaje))
        <ul>
            @foreach ($mensaje->all() as $error)
            <li>{{$error}}</li>
            @endforeach
        </ul>
        @else
            {{$mensaje}}
        @endif
    </p>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>