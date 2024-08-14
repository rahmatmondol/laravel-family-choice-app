@extends($masterLayout)
<?php
$page = 'boost page';
$title = 'boost';
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
              ({{ $count }})
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

          <form action="{{ route($mainRoutePrefix.'.boost.list') }}" method="get">

            <div class="row">

              <div class="col-md-4">
                <div class="form-group">
{{--                  <label for="inputType">@lang('site.EducationalSubjects')</label>--}}
                  <select name="status" class="form-control selectric"  data-live-search="true"
                          required>
                    <option value="active">Active </option>
                    <option value="inactive">In Active </option>

                  </select>
                </div>
            </div>

            <div class="col-md-4">
              <div class="form-group">
                <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-search"></i>
                  Filter</button>
                @if (checkAdminPermission('create_courses'))
                <a href="{{ route($mainRoutePrefix.'.boost.create') }}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i>
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
                city
              </th>
              <th style="width: 20%">
                Monthly Budget
              </th>
              <th style="width: 20%">
               Cost per click
              </th>
              <th style="width: 20%">
                Starting Date
              </th>
              <th style="width: 8%">
                Ending Date
              </th>

              <th style="width: 20%" class="text-center">
                @lang('site.Actions')
              </th>
            </tr>
          </thead>
          <tbody>
          @forelse($data as $discount)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $discount->citys->title }}</td>
              <td>{{ $discount->monthly_budget ?? 0}} EAD</td>
              <td>{{ $discount->cost_per_click ?? 0 }} EAD</td>

              <td>{{  Carbon\Carbon::parse($discount->starting)->format('F j, Y') }}</td>
              <td>{{  Carbon\Carbon::parse($discount->ending)->format('F j, Y') }}</td>

              <td class="project-actions text-right">

                              @include('school.partials._view_btn',[
                              'txt'=>__('site.View'),
                              'route'=>route($mainRoutePrefix.'.boost.show', ['id'=>$discount->id]),
                              ])
                              @include('school.partials._destroy_btn',[
                              'txt'=>__('site.Delete'),
                              'route'=>route($mainRoutePrefix.'.boost.delete', ['id'=>$discount->id]),
                              ])
                            </td>
            </tr>
          @empty
            <tr>
              <td colspan="9">No discounts found</td>
            </tr>
          @endforelse

          </tbody>
        </table>
{{--        {{ $courses->appends(request()->query())->links() }}--}}

      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection
