@if (Session::has('error'))
    <div class="alert alert-warning alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <span>{{Session::get('error')}}</span>
    </div>
@endif

@if (Session::has('success'))
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <span>{{Session::get('success')}}</span>
    </div>
@endif

