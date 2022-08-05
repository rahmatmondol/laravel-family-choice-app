@extends($masterLayout)
<?php
$page = 'customers';
$title = __('site.Customers');
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
              ( {{ $customers->total() }} )
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

          <form action="{{ route($mainRoutePrefix.'.customers.index') }}" method="get">

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

              {{-- verified --}}
              <div class="col-md-4">
                <div class="form-group">
                  <select id="inputverified" name="verified"  class="form-control custom-select">
                    <option value='' selected>@lang('site.Verification') </option>
                    <option value="1" @if(request('verified')==1) selected @endif>@lang('site.Verified')</option>
                    <option value="0" @if(request('verified')!==null && request('verified')=='0') selected @endif>@lang('site.Not Verified')</option>
                  </select>
                </div>
              </div>

              <div class="col-md-4">
                <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-search"></i>
                  @lang('site.Search')</button>
                @if (checkAdminPermission('create_customers'))
                <a href="{{ route($mainRoutePrefix.'.customers.create') }}" class="btn btn-sm btn-primary"><i
                    class="fa fa-plus"></i>
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
                @lang('site.Full Name')
              </th>
              <th style="width: 20%">
                @lang('site.Phone')
              </th>
              <th style="width: 20%">
                @lang('site.E-mail')
              </th>
              <th style="width: 20%">
                @lang('site.Reservations')
              </th>
              <th style="width: 20%">
                @lang('site.Image')
              </th>
              <th style="width: 8%" class="text-center">
                @lang('site.Status')
              </th>
              <th style="width: 8%" class="text-center">
                @lang('site.Verified')
              </th>
              <th style="width: 20%">
              </th>
            </tr>
          </thead>
          <tbody>
            @forelse ($customers as $customer )
            <tr>
              <td>
                {{ $loop->iteration }}
              </td>
              <td>
                {{ $customer->full_name }}
              </td>
              <td>
                {{ $customer->phone }}
              </td>
              <td>
                {{ $customer->email }}
              </td>
              <td>
                @include('admin.partials._view_btn',[
                'txt'=>__('site.Reservations'),
                'route'=>route($mainRoutePrefix.'.reservations.index', ['customer_id'=>$customer->id]),
                ])
              </td>
              <td>
                <a href="{{ $customer->image_path }}" data-fancybox data-caption="Caption for single image">
                  <img src="{{ $customer->image_path }}" style="width: 100px;" class="img-thumbnail" alt="">
                </a>
              </td>
              <td class="project-state">
                @include('admin.partials._render_status',['status'=>$customer->status])
              </td>
              <td class="project-state">
                @include('admin.partials._render_status',['status'=>$customer->verified])
              </td>
              <td class="project-actions text-right">

                @include('admin.partials._view_btn',[
                'txt'=>__('site.View'),
                'route'=>route($mainRoutePrefix.'.customers.show', ['customer'=>$customer->id]),
                ])

                @include('admin.partials._edit_btn',[
                'txt'=>__('site.Edit'),
                'route'=>route($mainRoutePrefix.'.customers.edit', ['customer'=>$customer->id]),
                ])

                @include('admin.partials._destroy_btn',[
                'txt'=>__('site.Delete'),
                'route'=>route($mainRoutePrefix.'.customers.destroy', $customer->id),
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
        {{ $customers->appends(request()->query())->links() }}

      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection
