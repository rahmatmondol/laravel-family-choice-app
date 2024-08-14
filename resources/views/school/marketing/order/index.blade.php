@extends($masterLayout)
<?php
$page = 'Discount';
$title = 'Discount';
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

          <form action="{{ route($mainRoutePrefix.'.discount.view') }}" method="get">

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
                <a href="{{ route($mainRoutePrefix.'.discount.add') }}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i>
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
              <th style="width: 8%">
                @lang('site.Title')
              </th>
              <th style="width: 8%">
                @lang('site.Type')
              </th>
              <th style="width: 8%">
                Discount Amount
              </th>
              <th style="width: 8%">
                Discount Percentage
              </th>
              <th style="width: 8%">
               Minimum Amount
              </th>
              <th style="width: 8%">
                Starting Date
              </th>
              <th style="width: 8%" >
                Ending Date
              </th>
              <th style="width: 8%">
                Status
              </th>
              <th style="width: 10%" >
                @lang('site.Actions')
              </th>
            </tr>
          </thead>
          <tbody>
          @forelse($data as $discount)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $discount->title }}</td>
              <td>{{ ucfirst($discount->discount_type) }}</td>
              <td>{{ $discount->discount_amount ?? 0 }} EAD</td>
              <td>{{ $discount->percentage_discount ?? 0 }} %</td>
              <td>{{ $discount->minimum_amount }} EAD</td>
              <td>{{ $discount->starting_date->format('F j, Y') }}</td>
              <td>{{ $discount->ending_date->format('F j, Y') }}</td>
              <td>{{ ucfirst($discount->status) }}</td>
              <td class="project-actions text-right">

                              @include('school.partials._view_btn',[
                              'txt'=>__('site.View'),
                              'route'=>route($mainRoutePrefix.'.discount.show', ['id'=>$discount->id]),
                              ])

{{--                              @include('school.partials._edit_btn',[--}}
{{--                              'txt'=>__('site.Edit'),--}}
{{--                              'route'=>route($mainRoutePrefix.'.courses.edit', ['course'=>$discount->id]),--}}
{{--                              ])--}}

                              @include('school.partials._destroy_btn',[
                              'txt'=>__('site.Delete'),
                              'route'=>route('school.discount.delete',['id'=>$discount->id]),
                              ])
                            </td>
            </tr>
          @empty
            <tr>
              <td colspan="9">No discounts found</td>
            </tr>
          @endforelse
{{--          @foreach($data as $course)--}}
{{--            <tr>--}}
{{--              <td>--}}
{{--                {{ $loop->iteration }}--}}
{{--              </td>--}}
{{--              <td>--}}
{{--                {{ $course->title }}--}}
{{--              </td>--}}
{{--              <td>--}}
{{--                @lang(ucfirst($course->type))--}}
{{--              </td>--}}
{{--              <td>--}}
{{--                {{ $course->subscription?->title }}--}}
{{--              </td>--}}
{{--              <td>--}}
{{--                {{ $course->from_date }}--}}
{{--              </td>--}}
{{--              <td>--}}
{{--                {{ $course->to_date }}--}}
{{--              </td>--}}
{{--              <td>--}}
{{--                <a href="{{ $course->image_path }}" data-fancybox data-caption="Caption for single image">--}}
{{--                  <img src="{{ $course->image_path }}" style="width: 100px;" class="img-thumbnail" alt="">--}}
{{--                </a>--}}
{{--              </td>--}}
{{--              <td class="project-state">--}}
{{--                @include('school.partials._render_status',['status'=>$course->status])--}}
{{--              </td>--}}
{{--              <td>--}}
{{--                {{ $course->order_column }}--}}
{{--              </td>--}}
{{--              <td class="project-actions text-right">--}}

{{--                @include('school.partials._view_btn',[--}}
{{--                'txt'=>__('site.View'),--}}
{{--                'route'=>route($mainRoutePrefix.'.courses.show', ['course'=>$course->id]),--}}
{{--                ])--}}

{{--                @include('school.partials._edit_btn',[--}}
{{--                'txt'=>__('site.Edit'),--}}
{{--                'route'=>route($mainRoutePrefix.'.courses.edit', ['course'=>$course->id]),--}}
{{--                ])--}}

{{--                @include('school.partials._destroy_btn',[--}}
{{--                'txt'=>__('site.Delete'),--}}
{{--                'route'=>route($mainRoutePrefix.'.courses.destroy', $course->id),--}}
{{--                ])--}}

{{--              </td>--}}
{{--            </tr>--}}
{{--          @empty--}}
{{--            <tr>--}}
{{--              <td>--}}
{{--                @include('school.partials.no_data_found')--}}
{{--              </td>--}}
{{--            </tr>--}}
{{--          @endforeach--}}

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
