@if (checkAdminPermission('delete_roles'))
<form action="{{ $route }}" method="post" style="display: inline-block">
  @csrf
  @method('delete')
  <button type="submit" class="btn btn-danger btn-sm confirm-delete"><i class="fas fa-trash"></i>
    {{ $txt }}
  </button>
</form><!-- end of form -->
@endif
