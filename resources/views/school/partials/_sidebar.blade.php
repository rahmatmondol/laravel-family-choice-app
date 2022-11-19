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
          <a href="{{ route($mainRoutePrefix.'.dashboard') }}" class="nav-link @if( $page == 'dashboard' )   active  @endif">
            <i class="nav-icon fas fa-columns"></i>
            <p>
              {{ucfirst(__('site.Dashboard'))}}
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route($mainRoutePrefix.'.profile.show') }}" class="nav-link @if( $page == 'profile' )   active  @endif">
            <i class="nav-icon fas fa-columns"></i>
            <p>
              {{ucfirst(__('site.Profile'))}}
            </p>
          </a>
        </li>

        @if($globalSchool->is_nursery_type)
        <li class="nav-item">
          <a href="{{ route($mainRoutePrefix.'.courses.index') }}" class="nav-link @if( $page == 'courses' )   active  @endif">
            <i class="nav-icon fas fa-columns"></i>
            <p>
              {{ucfirst(__('site.Courses'))}}
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route($mainRoutePrefix.'.subscription_types.index') }}" class="nav-link @if( $page == 'subscription_types' )   active  @endif">
            <i class="nav-icon fas fa-columns"></i>
            <p>
              {{ucfirst(__('site.Subscription Types'))}}
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route($mainRoutePrefix.'.nurseryFees.index') }}" class="nav-link @if( $page == 'nurseryFees' )   active  @endif">
            <i class="nav-icon fas fa-columns"></i>
            <p>
              {{ucfirst(__('site.NurseryFees'))}}
            </p>
          </a>
        </li>
        @endif



        @if($globalSchool->is_school_type)
        <li class="nav-item">
          <a href="{{ route($mainRoutePrefix.'.grades.index') }}" class="nav-link @if( $page == 'grades' )   active  @endif">
            <i class="nav-icon fas fa-columns"></i>
            <p>
              {{ucfirst(__('site.Grades'))}}
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route($mainRoutePrefix.'.gradeFees.index') }}" class="nav-link @if( $page == 'gradeFees' )   active  @endif">
            <i class="nav-icon fas fa-columns"></i>
            <p>
              {{ucfirst(__('site.GradeFees'))}}
            </p>
          </a>
        </li>
        @endif


        @foreach( $sideBarItems as $item)
        <li class="nav-item  active ">
          <a href="{{ route('school.'.$item.'.index') }}" class="nav-link @if( $page == $item )   active  @endif">
            <i class="nav-icon fas fa-columns"></i>
            <p>
              {{__('site.'.ucfirst($item))}}
            </p>
          </a>
        </li>
        @endforeach

        <li class="nav-item">
          <a href="{{ route($mainRoutePrefix.'.profile.change-password') }}" class="nav-link @if( $page == 'changePassword' )   active  @endif">
            <i class="nav-icon fas fa-columns"></i>
            <p>
              {{ucfirst(__('site.Change Password'))}}
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route($mainRoutePrefix.'.reservation-logs') }}" class="nav-link @if( $page == 'logs' )   active  @endif">
            <i class="nav-icon fas fa-columns"></i>
            <p>
              {{ucfirst(__('site.Logs'))}}
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route($mainRoutePrefix.'.payments.index') }}" class="nav-link @if( $page == 'payments' )   active  @endif">
            <i class="nav-icon fas fa-columns"></i>
            <p>
              {{ucfirst(__('site.Payments'))}}
            </p>
          </a>
        </li>

      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
