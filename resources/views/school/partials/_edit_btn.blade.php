@if (checkAdminPermission('read_roles'))
<a class="btn inline-flex justify-center btn-primary" href="{{ $route }}">
  <i class="fas fa-pencil-alt">
  </i>
  {{ $txt }}
</a>
@endif
