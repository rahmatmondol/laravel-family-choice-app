<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="{{ route('home') }}" class="brand-link">
    <img src="" alt="" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">{{ appName() }}</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{ $globalSchool->image_path }}" class="img-circle elevation-2" alt="">
      </div>
      <div class="info">
        <a href="#" class="d-block">{{ $globalSchool->title }}</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        {{-- <li class="nav-header">EXAMPLES</li> --}}

        <li class="nav-item">
          <a href="{{ route('admin.dashboard') }}" class="nav-link @if( $page == 'dashboard' )   active  @endif">
            <i class="nav-icon fas fa-columns"></i>
            <p>
              {{ucfirst(__('site.Dashboard'))}}
            </p>
          </a>
        </li>

        @foreach( $sideBarItems as $item)
        {{-- @if (auth()->user()->hasPermission('read_'.$item)) --}}
        <li class="nav-item  active ">
          <a href="{{ route('school.'.$item.'.index') }}" class="nav-link @if( $page == $item )   active  @endif">
            <i class="nav-icon fas fa-columns"></i>
            <p>
              {{__('site.'.ucfirst($item))}}
            </p>
          </a>
        </li>
        {{-- @endif --}}
        @endforeach

      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
