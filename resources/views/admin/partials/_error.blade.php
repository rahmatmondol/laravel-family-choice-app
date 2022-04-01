@if ($error = session('error'))
    <div class="alert alert-danger">
        <p>{{ $error }}</p>
    </div>
@endif
