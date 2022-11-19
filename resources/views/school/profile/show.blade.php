@extends($masterLayout)
<?php
$page = 'profile';
$title = __('site.Show school');
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
            <li class="breadcrumb-item"><a href="{{ route($mainRoutePrefix.'.dashboard') }}">@lang('site.Home')</a></li>
            <li class="breadcrumb-item"><a href="{{ route($mainRoutePrefix.'.profile.show') }}">@lang('site.School')</a>
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
      @include('school.partials._edit_btn',[
        'txt'=>__('site.Edit Profile'),
        'route'=>route($mainRoutePrefix.'.profile.edit'),
        ])
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-striped table-bordered">
          <tbody>
            <tr>
              <td>@lang('site.Title')</td>
              <td>{{ $school->title }}</td>
            </tr>
            <tr>
              <td>@lang('site.Address')</td>
              <td>{{ $school->address }}</td>
            </tr>
            <tr>
              <td>@lang('site.Description')</td>
              <td>{{ $school->description }}</td>
            </tr>
            <tr>
              <td>@lang('site.Types')</td>
              <td>
                <span class="btn btn-primary btn-customs py-1 px-2">{{ $school->type?->title }}</span>
              </td>
            </tr>
            <tr>
              <td>@lang('site.Services')</td>
              <td>
                @foreach ($school->services as $service)
                <span class="btn btn-primary btn-customs py-1 px-2">{{ $service->title }}</span>
                @endforeach
              </td>
            </tr>
            <tr>
              <td>@lang('site.EducationTypes')</td>
              <td>
                @foreach ($school->educationTypes as $educationType)
                <span class="btn btn-primary btn-customs py-1 px-2">{{ $educationType->title }}</span>
                @endforeach
              </td>
            </tr>
            <tr>
              <td>@lang('site.SchoolTypes')</td>
              <td>
                @foreach ($school->schoolTypes as $schoolType)
                <span class="btn btn-primary btn-customs py-1 px-2">{{ $schoolType->title }}</span>
                @endforeach
              </td>
            </tr>
            <tr>
              <td>@lang('site.Grades')</td>
              <td>
                @foreach ($school->grades as $grade)
                <span class="btn btn-primary btn-customs py-1 px-2">{{ $grade->title }}</span>
                @endforeach
              </td>
            </tr>
            <tr>
              <td>@lang('site.Phone')</td>
              <td>{{ $school->phone }}</td>
            </tr>
            <tr>
              <td>@lang('site.Whatsapp')</td>
              <td>{{ $school->whatsapp }}</td>
            </tr>
            <tr>
              <td>@lang('site.E-mail')</td>
              <td>{{ $school->email }}</td>
            </tr>
            <tr>
              <td>@lang('site.Available seats')</td>
              <td>{{ $school->available_seats }}</td>
            </tr>
            <tr>
              <td>@lang('site.Total seats')</td>
              <td>{{ $school->total_seats }}</td>
            </tr>
            <tr>
              <td>@lang('site.Status')</td>
              <td>@include('admin.partials._render_status',['status'=>$school->status])</td>
            </tr>
            <tr>
              <td>@lang('site.Image')</td>
              <td><img src="{{ $school->image_path }}" style="width: 100px" class="img-thumbnail image-preview1" alt="">
              </td>
            </tr>
            <tr>
              <td>@lang('site.Cover')</td>
              <td><img src="{{ $school->cover_path }}" style="width: 100px" class="img-thumbnail image-preview1" alt="">
              </td>
            </tr>
            <tr>
              <td>@lang('site.Attachments')</td>
              <td>
                @foreach ($school->schoolImages as $img )
                <img src="{{ $img->image_path }}" style="width: 100px" class="img-thumbnail image-preview1" alt="">
                @endforeach
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
