@extends($masterLayout)
<?php
$page = 'gradeFees';
$title = __('site.Edit GradeFees');
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
            <li class="breadcrumb-item"><a href="{{ route($mainRoutePrefix.'.gradeFees.index') }}">@lang('site.GradeFees')</a>
            </li>
            <li class="breadcrumb-item active">{{ $title }}</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <form method="post" action="{{ route($mainRoutePrefix.'.gradeFees.update',$gradeFees->id)}}" enctype="multipart/form-data">
      @csrf
      @method('put')
      @include('school.partials._errors')
      <input type="hidden" name="school_id" value="{{ $globalSchool->id }}">
      <div class="row">
        <div class="col-md-6">
          <div class="card card-primary">
            <div class="card-body">

              @foreach (config('translatable.locales') as $key => $locale)
              <div class="form-group">
                <label>@lang('site.' . $locale . '.Title')</label>
                <input required="required" type="text" name="{{ $locale }}[title]" class="form-control"
                  value="{{ old($locale . '.title',$gradeFees->translate($locale)->title) }}">
              </div>
              <div class="  with-border"></div><br>
              @endforeach
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <div class="col-md-6">
          <div class="card card-primary">
            <div class="card-body">
              
              {{-- grades --}}
              <div class="form-group">
                <label>@lang('site.Grades')</label>
                <select name="grade_id" class="form-control" required>
                  <option value='' selected disabled>@lang('site.Grades')</option>
                  @foreach ($grades as $grade)
                  <option value="{{ $grade->id }}" @selected(old('grade_id',$gradeFees->grade_id)==$grade->id)>
                    {{$grade->title }}</option>
                  @endforeach
                </select>
              </div>

              {{-- price --}}
              <div class="form-group">
                <label>@lang('site.Price')</label>
                <input type="text" name="price" value="{{ old('price',$gradeFees->price) }}"
                  class="form-control" required
                  oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');">
              </div>

              {{-- order_column --}}
              <div class="form-group">
                <label>@lang('site.Order Item')</label>
                <input type="text" name="order_column" value="{{ old('order_column',$gradeFees->order_column) }}"
                  class="form-control"
                  oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');">
              </div>

              {{-- status --}}
              <div class="form-group">
                <label for="inputStatus">@lang('site.Status')</label>
                <select id="inputStatus" name="status" required class="form-control custom-select">
                  <option value='' selected disabled>@lang('site.Status')</option>
                  <option value="1" @if(old('status',$gradeFees->status)==1) selected @endif>@lang('site.Active')</option>
                  <option value="0" @if(old('status',$gradeFees->status)==0) selected @endif>@lang('site.In-Active')
                  </option>
                </select>
              </div>

            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <button class="btn btn-success" type="submit" name='continue' value='continue'><i class="fas fa-save"></i>
            @lang('site.Save & Continue')</button>
          <button class="btn btn-success" type="submit"><i class="fas fa-save"></i> @lang('site.Save')</button>
        </div>
      </div>
    </form>
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection
