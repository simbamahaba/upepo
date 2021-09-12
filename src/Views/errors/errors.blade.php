@if(count($errors)>0)
<div class="alert alert-danger alert-dismissible " role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
    </button>
    @foreach($errors->all() as $error)
        <p><i class="fa fa-exclamation-circle" aria-hidden="true"></i> {{ $error }}</p>
    @endforeach
    <hr>
    <p>Vă rugăm să remediați erorile existente.</p>
</div>
@endif
