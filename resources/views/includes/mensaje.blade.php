@if (session("mensaje"))
<div class="alert alert-block alert-success"  data-auto-dismiss="3000">
    <button type="button" class="close" data-dismiss="alert">
        <i class="ace-icon fa fa-times"></i>
    </button>

    <p>
        <strong>
            <i class="ace-icon fa fa-check"></i>
            Well done!
        </strong>
        You successfully read this important alert message.
    </p>

    <p>
        <button class="btn btn-sm btn-success">Do This</button>
        <button class="btn btn-sm">Or This One</button>
    </p>
</div>
@endif