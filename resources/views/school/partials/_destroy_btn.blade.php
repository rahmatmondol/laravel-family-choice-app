@if (checkAdminPermission('delete_roles'))
    <form action="{{ $route }}" method="post" style="display: inline-block">
        @csrf
        @method('delete')
        <button type="submit" class="action-btn">
            <iconify-icon icon="heroicons:trash"></iconify-icon>
        </button>
    </form><!-- end of form -->
@endif
