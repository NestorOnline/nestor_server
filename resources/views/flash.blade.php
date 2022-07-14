@if (Session::has('success'))
<div class="alert alert-success {{Session::has('important')? 'alert-important' : ''}}">
    @if (Session::has('important'))
    <button type="button" class="close" data-dismiss="alert" area-hidden="true">&times;</button>
    @endif
    <strong><i class="fa fa-exclamation-circle"></i> Success!</strong> {{session('success')}}
</div>
@endif

@if (Session::has('warning'))
<div class="alert alert-warning {{Session::has('important')? 'alert-important' : ''}}">
    @if (Session::has('important'))
    <button type="button" class="close" data-dismiss="alert" area-hidden="true">&times;</button>
    @endif
    <strong><i class="fa fa-exclamation-circle"></i> Warning!</strong> {{session('warning')}}
</div>
@endif

@if (Session::has('info'))
<div class="alert alert-info {{Session::has('important')? 'alert-important' : ''}}">
    @if (Session::has('important'))
    <button type="button" class="close" data-dismiss="alert" area-hidden="true">&times;</button>
    @endif
    <strong><i class="fa fa-exclamation-circle"></i> Alert! </strong> {{session('info')}}
</div>
@endif

@if (count($errors) > 0)
<div class="alert alert-danger alert-important">
    <button type="button" class="close" data-dismiss="alert" area-hidden="true">&times;</button>
    <strong><i class="fa fa-exclamation-circle"></i> Whoops!</strong> There were some problems with your input.<br>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif


@if (Session::has('error'))
<div class="alert alert-danger alert-important red ">
    <button type="button" class="close" data-dismiss="alert" area-hidden="true">&times;</button>
    <strong><i class="fa fa-exclamation-circle"></i> Error! </strong> {{session('error')}}
</div>
@endif

