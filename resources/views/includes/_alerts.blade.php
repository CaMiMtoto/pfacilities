@if(session()->has('success'))
    <div class="alert alert-success flat alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
        <strong>Success!</strong> {{ session()->get('success') }}.
    </div>
@endif

@if(session()->has('error'))
    <div class="alert alert-danger flat alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
        <strong>Error!</strong> {{ session()->get('error') }}.
    </div>
@endif
@if(session()->has('warning'))
    <div class="alert alert-warning flat alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
        <strong>Warning!</strong> {{ session()->get('warning') }}.
    </div>
@endif
@if(session()->has('info'))
    <div class="alert alert-info flat alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
        <strong>Info!</strong> {{ session()->get('info') }}.
    </div>
@endif
