@if ($error = session('error'))
    <div class="alert alert-danger">
        <p>{{ $error }}</p>
    </div>
@endif

@if ($success = session('success'))
    <div class="alert alert-success">
        <p>{{ $success }}</p>
    </div>
@endif
