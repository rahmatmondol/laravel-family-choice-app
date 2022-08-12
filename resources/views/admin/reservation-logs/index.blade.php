@extends($masterLayout)
<?php
$page = 'logs';
$title = __('site.Logs');
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
              ( {{ $logs->total() }} )
            </small>
          </h6>

        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-center">
            <li class="breadcrumb-item"><a href="{{ route($mainRoutePrefix.'.dashboard') }}">@lang('site.Home')</a></li>
            <li class="breadcrumb-item active">{{ $title }}</li>
          </ol>
        </div>
        <div class="col-sm-12">

          <form action="{{ route($mainRoutePrefix.'.reservation-logs') }}" method="get">

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
              <th style="width: 20%" class="text-center">
                @lang('site.Reservation Number')
              </th>
              <th style="width: 20%" class="text-center">
                @lang('site.Description')
              </th>
              <th style="width: 20%" class="text-center">
                @lang("site.User Name")
              </th>
              <th style="width: 20%" class="text-center">
                @lang("site.User Type")
              </th>
              <th style="width: 20%" class="text-center">
                @lang('site.Created At')
              </th>
            </tr>
          </thead>
          <tbody>
            @forelse ($logs as $log )
            <tr>
              <td class="text-center">
                {{ $loop->iteration }}
              </td>
              <td class="text-center">
                {{ $log->subject_id }}
              </td>
              <td class="text-center">
                {{ $log->description }}
              </td>
              <td class="text-center">
                {{ $log->causer_full_name  }}
              </td>
              <td class="text-center">
                {{ $log->causer_model_type  }}
              </td>
              <td class="text-center">
                {{ $log->created_at }}
              </td>
            </tr>
            @empty
            <tr>
              <td class="text-center">
                @include('admin.partials.no_data_found')
              </td>
            </tr>
            @endforelse

          </tbody>
        </table>
        {{ $logs->appends(request()->query())->links() }}

      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection
