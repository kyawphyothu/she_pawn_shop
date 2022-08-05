@if (session('info'))
    <div class="alert alert-info">
        {{-- <button type="button" class="close" data-dismiss="alert">×</button> --}}
        <strong>{{ session('info') }}</strong>
    </div>
@elseif (session('success'))
    <div class="alert alert-success">
        {{-- <button type="button" class="close" data-dismiss="alert">×</button> --}}
        <strong>{{ session('success') }}</strong>
    </div>
@elseif (session('warning'))
    <div class="alert alert-warning">
        {{-- <button type="button" class="close" data-dismiss="alert">×</button> --}}
        <strong>{{ session('warning') }}</strong>
@elseif (session('danger'))
    <div class="alert alert-danger">
        {{-- <button type="button" class="close" data-dismiss="alert">×</button> --}}
        <strong>{{ session('danger') }}</strong>
    </div>
@endif
