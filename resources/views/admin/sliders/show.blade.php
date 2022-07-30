@extends($masterLayout)
<?php
$page = 'sliders';
$title = __('site.Show Slider');
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
          <h6>{{ $title }}</h6>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">@lang('site.Home')</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.sliders.index') }}">@lang('site.Sliders')</a>
            </li>
            <li class="breadcrumb-item active">{{ $title }}</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Content -->
  <div class="card mt-4 content-table">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-striped table-bordered">
          <tbody>
            <tr>
              <td>@lang('site.Title')</td>
              <td>{{ $slider->title }}</td>
            </tr>
            <tr>
              <td>@lang('site.Description')</td>
              <td>{{ $slider->description }}</td>
            </tr>
            <tr>
              <td>@lang('site.School')</td>
              <td>{{ $slider->school?->title }}</td>
            </tr>
            <tr>
              <td>@lang('site.Link')</td>
              <td>{{ $slider->link }}</td>
            </tr>
            <tr>
              <td>@lang('site.Order Item')</td>
              <td>{{ $slider->order_column }}</td>
            </tr>
            <tr>
              <td>@lang('site.Status')</td>
              <td>@include('admin.partials._render_status',['status'=>$slider->status])</td>
            </tr>
            <tr>
              <td>@lang('site.Image')</td>
              <td><img src="{{ $slider->image_path }}" style="width: 100px" class="img-thumbnail image-preview1" alt="">
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <!-- //Content -->
</div>
<!-- /.content-wrapper -->
@endsection
