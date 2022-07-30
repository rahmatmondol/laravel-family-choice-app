@extends($masterLayout)
<?php
$page = 'grades';
$title = __('site.Edit Grade');
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
            <li class="breadcrumb-item"><a
                href="{{ route('admin.schools.grades.index',['school' => $school->id]) }}">@lang('site.Grades')</a>
            </li>
            <li class="breadcrumb-item active">{{ $title }}</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <form method="post"
      action="{{ route('admin.schools.grades.update',['school'=>$schoolGrade->school_id,'grade'=>$schoolGrade->grade_id]) }}"
      enctype="multipart/form-data">
      @csrf
      @method('put')
      @include('admin.partials._errors')
      <input type="hidden" name="school_id" value="{{ $school->id }}">

      <div class="row">
        <div class="col-md-6">
          <div class="card card-primary">
            <div class="card-body">

              {{-- grades --}}
              <div class="form-group">
                <label for="inputType">@lang('site.grades')</label>
                <select name="grade_id" class="form-control" required disabled>
                  <option value="">@lang('site.grades') </option>
                  @foreach( $grades as $value )
                  <option value="{{ $value->id}}" @if( old('grade_id',$schoolGrade->grade_id)==$value->id ) selected
                    @endif>
                    {{ $value->title }}</option>
                  @endforeach
                </select>
              </div>

              {{-- status --}}
              <div class="form-group">
                <label for="inputStatus">@lang('site.Status')</label>
                <select id="inputStatus" name="status" required class="form-control custom-select">
                  <option value='' selected disabled>@lang('site.Status')</option>
                  <option value="1" @if(old('status',$schoolGrade->status)==1) selected @endif>@lang('site.Active')
                  </option>
                  <option value="0" @if(old('status',$schoolGrade->status)==0) selected @endif>@lang('site.In-Active')
                  </option>
                </select>
              </div>

            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <div class="col-md-6">
          <div class="card card-primary">
            <div class="card-body">

              {{-- fees --}}
              <div class="form-group">
                <label>@lang('site.Fees')</label>
                <input required="required" type="text" name="fees" class="form-control"
                  value="{{old('fees',$schoolGrade->fees)}}"
                  oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');">
              </div>

              {{-- administrative_expenses --}}
              <div class="form-group">
                <label>@lang('site.Administrative expenses')</label>
                <input required="required" type="text" name="administrative_expenses" class="form-control"
                  value="{{old('administrative_expenses',$schoolGrade->administrative_expenses)}}"
                  oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');">
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
