@extends($masterLayout)
<?php
$page = 'schools';
$title = __('site.Grades');
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
              {{-- ( {{ $grades->total() }} ) --}}
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

          <form action="{{ route($mainRoutePrefix.'.grades.index') }}" method="get">

            <div class="row">
              <div class="col-md-4">
                @if (checkAdminPermission('create_grades'))
                <a href="{{ route($mainRoutePrefix.'.grades.create') }}"
                  class="btn btn-sm btn-primary"><i class="fa fa-plus"></i>
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
                @lang('site.Grade')
              </th>
              <th style="width: 8%" class="text-center">
                @lang('site.Status')
              </th>
              <th style="width: 20%" class="text-center">
                @lang('site.Actions')
              </th>
            </tr>
          </thead>
          <tbody>
            @forelse ($grades as $grade )
            <tr>
              <td>
                {{ $loop->iteration }}
              </td>
              {{-- <td>
                {{ $grade->school->title }}
              </td> --}}
              <td>
                {{ $grade->title }}
              </td>
              <td class="project-state">
                @include('school.partials._render_status',['status'=>$grade->pivot->status])
              </td>

              <td class="project-actions text-right">
                @include('school.partials._view_btn',[
                'txt'=>__('site.View'),
                'route'=>route($mainRoutePrefix.'.grades.show', ['grade'=>$grade->id]),
                'permission' =>'read_grades',
                ])

                @include('school.partials._edit_btn',[
                'txt'=>__('site.Edit'),
                'route'=>route($mainRoutePrefix.'.grades.edit', ['grade'=>$grade->id]),
                'permission' =>'update_grades',
                ])

                @include('school.partials._destroy_btn',[
                'txt'=>__('site.Delete'),
                'route'=>route($mainRoutePrefix.'.grades.destroy', ['grade'=>$grade->id]),
                'permission' =>'delete_grades',
                ])
              </td>
            </tr>
            @empty
            <tr>
              <td>
                @include('school.partials.no_data_found')
              </td>
            </tr>
            @endforelse

          </tbody>
        </table>
        {{-- {{ $grades->appends(request()->query())->links() }} --}}

      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection
