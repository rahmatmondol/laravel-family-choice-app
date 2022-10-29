@extends($masterLayout)
<?php
$page = 'courses';
$title = __('site.Courses');
?>
@section('title_page')
{{ $title }}
@endsection
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h6>{{ $title }}
            <small>
              ( {{ $courses->total() }} )
            </small>
          </h6>

        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route($mainRoutePrefix.'.dashboard') }}">@lang('site.Home')</a></li>
            <li class="breadcrumb-item active">{{ $title }}</li>
          </ol>
        </div>
        <div class="col-sm-12">

          <form action="{{ route($mainRoutePrefix.'.courses.index') }}" method="get">

            <div class="row">

              <div class="col-md-4">
                <div class="form-group">
                  <input type="text" name="search" class="form-control" placeholder="@lang('site.search')"
                    value="{{ request()->search }}">
                </div>
            </div>

            <div class="col-md-4">
              <div class="form-group">
                <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-search"></i>
                  @lang('site.Search')</button>
                @if (checkAdminPermission('create_courses'))
                <a href="{{ route($mainRoutePrefix.'.courses.create') }}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i>
                  @lang('site.Add')</a>
                @endif
              </div>
            </div>

            </div>
          </form><!-- end of form -->
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">{{ $title }}</h3>

        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body p-0">
        <table class="table table-striped projects">
          <thead>
            <tr>
              <th style="width: 1%">
                #
              </th>
              <th style="width: 20%">
                @lang('site.Title')
              </th>
              <th style="width: 20%">
                @lang('site.Type')
              </th>
              <th style="width: 20%">
                @lang('site.From Date')
              </th>
              <th style="width: 20%">
                @lang('site.To Date')
              </th>
              <th style="width: 20%">
                @lang('site.Image')
              </th>
              <th style="width: 8%" class="text-center">
                @lang('site.Status')
              </th>
              <th style="width: 8%" class="text-center">
                @lang('site.table.Order Item')
              </th>
              <th style="width: 20%" class="text-center">
                @lang('site.Actions')
              </th>
            </tr>
          </thead>
          <tbody>
            @forelse ($courses as $course )
            <tr>
              <td>
                {{ $loop->iteration }}
              </td>
              <td>
                {{ $course->title }}
              </td>
              <td>
                @lang('site.'.$course->type)
              </td>
              <td>
                {{ $course->from_date }}
              </td>
              <td>
                {{ $course->to_date }}
              </td>
              <td>
                <a href="{{ $course->image_path }}" data-fancybox data-caption="Caption for single image">
                  <img src="{{ $course->image_path }}" style="width: 100px;" class="img-thumbnail" alt="">
                </a>
              </td>
              <td class="project-state">
                @include('admin.partials._render_status',['status'=>$course->status])
              </td>
              <td>
                {{ $course->order_column }}
              </td>
              <td class="project-actions text-right">

                @include('admin.partials._view_btn',[
                'txt'=>__('site.View'),
                'route'=>route($mainRoutePrefix.'.courses.show', ['course'=>$course->id]),
                ])

                @include('admin.partials._edit_btn',[
                'txt'=>__('site.Edit'),
                'route'=>route($mainRoutePrefix.'.courses.edit', ['course'=>$course->id]),
                ])

                @include('admin.partials._destroy_btn',[
                'txt'=>__('site.Delete'),
                'route'=>route($mainRoutePrefix.'.courses.destroy', $course->id),
                ])

              </td>
            </tr>
            @empty
            <tr>
              <td>
                @include('admin.partials.no_data_found')
              </td>
            </tr>
            @endforelse

          </tbody>
        </table>
        {{ $courses->appends(request()->query())->links() }}

      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection
