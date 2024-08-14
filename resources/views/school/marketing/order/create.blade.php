@extends($masterLayout)
<?php
$page = 'Discount Page';
$title = 'Add Discount';
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
              <li class="breadcrumb-item"><a href="{{ route('school.discount.view') }}">@lang('site.Discounts')</a></li>
              <li class="breadcrumb-item active">{{ $title }}</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <form method="post" action="{{ route('school.discount.store') }}" enctype="multipart/form-data" id="discountForm">
        @csrf
        @include('school.partials._errors')
        <input type="hidden" name="school_id" value="{{ $globalSchool->id }}">
        <div class="row">
          <div class="col-md-6">
            <div class="card card-primary">
              <div class="card-body">

                {{-- Title --}}
                <div class="form-group">
                  <label>Title</label>
                  <input type="text" name="title" value="{{ old('title') }}" class="form-control" required>
                </div>

                {{-- Minimum Amount --}}
                <div class="form-group">
                  <label>Minimum Amount</label>
                  <input type="number" name="minimum_amount" value="{{ old('minimum_amount') }}" class="form-control" required min="0">
                </div>

                {{-- Starting Date --}}
                <div class="form-group">
                  <label>Starting Date</label>
                  <input type="date" name="starting_date" value="{{ old('starting_date') }}" class="form-control" required>
                </div>

                {{-- Ending Date --}}
                <div class="form-group">
                  <label>Ending Date</label>
                  <input type="date" name="ending_date" value="{{ old('ending_date') }}" class="form-control" required>
                </div>

                {{-- Status --}}
                <div class="form-group">
                  <label>Status</label>
                  <select name="status" class="form-control" required>
                    <option value='' selected disabled>Select Status</option>
                    <option value="1" >Active</option>
                    <option value="0" >In-Active</option>
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

                {{-- Discount Type --}}
                <div class="form-group">
                  <label>Discount Type</label>
                  <select name="discount_type" class="form-control" required id="discount_type">
                    <option value='' selected disabled>Select Discount Type</option>
                    <option value="percentage" @if(old('discount_type')=='percentage') selected @endif>Percentage</option>
                    <option value="fixed" @if(old('discount_type')=='fixed') selected @endif>Fixed Amount</option>
                  </select>
                </div>

                {{-- Percentage Discount --}}
                <div class="form-group" id="percentage_discount_group" style="display: none;">
                  <label>Percentage Discount</label>
                  <input type="number" name="percentage_discount" value="{{ old('percentage_discount') }}" class="form-control" min="0" max="100">
                </div>

                {{-- Discount Amount --}}
                <div class="form-group" id="discount_amount_group" style="display: none;">
                  <label>Discount Amount</label>
                  <input type="number" name="discount_amount" value="{{ old('discount_amount') }}" class="form-control">
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
  <!-- /.content-wrapper -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const discountTypeSelect = document.querySelector('select[name="discount_type"]');
      const percentageDiscountGroup = document.getElementById('percentage_discount_group');
      const discountAmountGroup = document.getElementById('discount_amount_group');
      const discountForm = document.getElementById('discountForm');

      function toggleDiscountFields() {
        if (discountTypeSelect.value === 'percentage') {
          percentageDiscountGroup.style.display = 'block';
          discountAmountGroup.style.display = 'none';
        } else if (discountTypeSelect.value === 'fixed') {
          percentageDiscountGroup.style.display = 'none';
          discountAmountGroup.style.display = 'block';
        } else {
          percentageDiscountGroup.style.display = 'none';
          discountAmountGroup.style.display = 'none';
        }
      }

      function handleFormSubmit(event) {
        // Remove discount_amount input if the discount type is percentage
        if (discountTypeSelect.value === 'percentage') {
          discountAmountGroup.querySelector('input').removeAttribute('name');
        } else if (discountTypeSelect.value === 'fixed') {
          percentageDiscountGroup.querySelector('input').removeAttribute('name');
        }
      }

      discountTypeSelect.addEventListener('change', toggleDiscountFields);
      discountForm.addEventListener('submit', handleFormSubmit);
      toggleDiscountFields();  // Initial call to set correct state on page load
    });
  </script>
@endsection

@push('scripts')

@endpush
