@if (checkAdminPermission('read_roles'))
<a class="btn btn-info btn-sm" href="{{ $route }}">
  <i class="fas fa-pencil-alt">
  </i>
  {{ $txt }}
</a>
@endif
