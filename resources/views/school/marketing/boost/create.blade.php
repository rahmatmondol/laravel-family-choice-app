@extends($masterLayout)
<?php
$page = 'Boosting Page';
$title = 'Add Boost';
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
              <li class="breadcrumb-item"><a href="{{ route('school.dashboard') }}">@lang('site.Home')</a></li>
              <li class="breadcrumb-item"><a href="{{ route('school.boost.list') }}">@lang('site.Boosts')</a></li>
              <li class="breadcrumb-item active">{{ $title }}</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <form method="post" action="{{route('school.boost.store')}}" enctype="multipart/form-data">
        @csrf
        @method('post')
        @include('school.partials._errors')
        <input type="hidden" name="school_id" value="{{ $globalSchool->id }}">
        <div class="row">
          <div class="col-md-6">
            <div class="card card-primary">
              <div class="card-body">

                {{-- City ID --}}
                <div class="form-group">
                  <label>City</label>
                  <select name="city_id" class="form-control" required>
                    <option value='' selected disabled>Select City</option>
                    @foreach ($cities as $city)
                      <option value="{{ $city->id }}" @if(old('city_id')==$city->id) selected @endif>{{ $city->title }}</option>
                    @endforeach
                  </select>
                </div>

                {{-- Monthly Budget --}}
                <div class="form-group">
                  <label>Monthly Budget</label>
                  <input type="number" name="monthly_budget" id="monthly_budget" value="{{ old('monthly_budget') }}" class="form-control" required min="441">
                  <small id="budgetError" class="form-text text-danger" style="display: none;">The monthly budget must be between 441 AED and 2000 AED.</small>

                </div>

                {{-- Cost Per Click --}}
                <div class="form-group">
                  <label>Cost per Click</label>
                  <select name="cost_per_click" id="cost_per_click" class="form-control" id="">
                    <option value="" selected disabled>Select</option>
                    @for($i=2.5;$i <= 6.5;$i+=0.5)
                      <option value="{{$i}}">{{$i}} AED</option>
                    @endfor
                  </select>
{{--                  <input type="number" name="cost_per_click" value="{{ old('cost_per_click') }}" class="form-control" required step="0.01" min="2.4" max="6.5">--}}
                </div>

                {{-- Starting Date --}}
                <div class="form-group">
                  <label>Staring Date</label>
                  <input type="date" name="starting" value="{{ old('starting') }}" class="form-control" required>
                </div>

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <div class="col-md-6">
            <div class="card card-primary">
              <div class="card-body">

                {{-- Order Column --}}
                <div class="form-group">
                  <h2 class="text-danger">Attention Please !!</h2>
                  <small class="form-text text-muted">Please enter maximum allowed value is between 100 - 400.</small>

                </div>



              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button class="btn btn-success" type="submit"><i class="fas fa-save"></i> @lang('site.Save')</button>
          </div>
        </div>
      </form>
    </section>
    <!-- /.content -->
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const monthlyBudgetInput = document.getElementById('monthly_budget');
      const budgetError = document.getElementById('budgetError');

      monthlyBudgetInput.addEventListener('input', function () {
        let value = parseFloat(this.value);

        if (isNaN(value) || value < 0) {
          this.value = 441;
          budgetError.style.display = 'none';
        } else if (value < 441 || value > 2000) {
          budgetError.style.display = 'block';
        } else {
          budgetError.style.display = 'none';
        }
      });
    });
  </script>

  <!-- /.content-wrapper -->
@endsection
