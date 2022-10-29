@extends($masterLayout)
<?php
$page = 'schools';
$title = __('site.Schools');
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
              ( {{ $schools->total() }} )
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

          <form action="{{ route($mainRoutePrefix.'.schools.index') }}" method="get">

            <div class="row">

              <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="@lang('site.search')"
                  value="{{ request()->search }}">
              </div>

              {{-- status --}}
              <div class="col-md-4">
                <div class="form-group">
                  <select id="inputStatus" name="status"  class="form-control custom-select">
                    <option value='' selected>@lang('site.Status') </option>
                    <option value="1" @if(request('status')==1) selected @endif>@lang('site.Active')</option>
                    <option value="0" @if(request('status')!==null && request('status')=='0') selected @endif>@lang('site.In-Active')</option>
                  </select>
                </div>
              </div>

              <div class="col-md-4">
                <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-search"></i>
                  @lang('site.Search')</button>
                @if (checkAdminPermission('create_schools'))
                <a href="{{ route($mainRoutePrefix.'.schools.create') }}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i>
                  @lang('site.Add')</a>
                @endif
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
                @lang('site.E-mail')
              </th>
              <th style="width: 20%">
                @lang('site.Grades')
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
            @forelse ($schools as $school )
            <tr>
              <td>
                {{ $loop->iteration }}
              </td>
              <td>
                {{ $school->title }}
              </td>
              <td>
                {{ $school->email }}
              </td>
              <td>
                @include('admin.partials._view_btn',[
                'txt'=>__('site.Grades'),
                'route'=>route($mainRoutePrefix.'.schools.grades.index', ['school'=>$school->id]),
                ])
              </td>
              <td class="project-state">
                @include('admin.partials._render_status',['status'=>$school->status])
              </td>

              <td>
                {{ $school->order_column }}
              </td>
              <td class="project-actions text-right">

                @include('admin.partials._view_btn',[
                'txt'=>__('site.View'),
                'route'=>route($mainRoutePrefix.'.schools.show', ['school'=>$school->id]),
                ])

                @include('admin.partials._edit_btn',[
                'txt'=>__('site.Edit'),
                'route'=>route($mainRoutePrefix.'.schools.edit', ['school'=>$school->id]),
                ])

                @include('admin.partials._destroy_btn',[
                'txt'=>__('site.Delete'),
                'route'=>route($mainRoutePrefix.'.schools.destroy', $school->id),
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
        {{ $schools->appends(request()->query())->links() }}

      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection
