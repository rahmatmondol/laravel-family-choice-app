@if (checkAdminPermission($permission))
<a class="btn btn-info btn-sm" href="{{ $route }}">
  <i class="fas fa-pencil-alt">
  </i>
  {{ $txt }}
</a>
@endif
