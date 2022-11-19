@if (checkAdminPermission($permission))
<a class="btn btn-primary btn-sm" href="{{ $route }}">
  <i class="fas fa-folder">
  </i>
  {{ $txt }}
</a>
@endif
