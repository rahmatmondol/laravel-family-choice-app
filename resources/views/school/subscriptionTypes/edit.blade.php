@extends($masterLayout)
<?php
$page = 'subscriptionTypes';
$title = __('site.Edit Subscription Type');
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
            <li class="breadcrumb-item"><a href="{{ route($mainRoutePrefix.'.subscriptionTypes.index') }}">@lang('site.SubscriptionTypes')</a>
            </li>
            <li class="breadcrumb-item active">{{ $title }}</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <form method="post" action="{{ route($mainRoutePrefix.'.subscriptionTypes.update',$subscriptionType->id)}}" enctype="multipart/form-data">
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
                  value="{{ old($locale . '.title',$subscriptionType->translate($locale)->title) }}">
              </div>
              <div class="form-group">
                <label>@lang('site.' . $locale . '.Appointment')</label>
                <input required="required" type="text" name="{{ $locale }}[appointment]" class="form-control"
                  value="{{ old($locale . '.appointment',$subscriptionType->translate($locale)->appointment) }}">
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

              {{-- subscriptions --}}
              <div class="form-group">
                <label>@lang('site.Subscriptions')</label>
                <select name="subscription_id" class="form-control" required>
                  <option value='' selected disabled>@lang('site.Subscriptions')</option>
                  @foreach ($subscriptions as $subscription)
                  <option value="{{ $subscription->id }}" @selected(old('subscription_id',$subscriptionType->subscription_id)==$subscription->id)>
                  {{  $subscription->title }}</option>
                  @endforeach
                </select>
              </div>

              {{-- types --}}
              <div class="form-group">
                <label for="inputStatus">@lang('site.Status')</label>
                <select id="inputStatus" name="type" required class="form-control custom-select">
                  <option value='' selected disabled>@lang('site.Status')</option>
                  @foreach(\App\Enums\SubscriptionTypes::cases() as $sub_type)
                  <option value="{{ $sub_type->value }}"
                  @selected(old('type',$subscriptionType->type)==$sub_type->value)>
                    @lang('site.SubscriptionType.'.$sub_type->value)
                  </option>
                  @endforeach
                  </option>
                </select>
              </div>

              {{-- number_of_days --}}
              <div class="form-group">
                <label for="inputStatus">@lang('site.Number Of Days')</label>
                <select id="inputStatus" name="number_of_days" required class="form-control custom-select">
                  <option value='' selected disabled>@lang('site.Number Of Days')</option>
                  @for ($i = 1; $i <= 7; $i++)
                  <option value="{{ $i }}" @selected(old('number_of_days',$subscriptionType->number_of_days)==$i)>{{ $i }}</option>
                  @endfor
                </select>
              </div>

              {{-- price --}}
              <div class="form-group">
                <label>@lang('site.Price')</label>
                <input type="text" name="price" value="{{ old('price',$subscriptionType->price) }}"
                  class="form-control"
                  oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');">
              </div>

              {{-- order_column --}}
              <div class="form-group">
                <label>@lang('site.Order Item')</label>
                <input type="text" name="order_column" value="{{ old('order_column',$subscriptionType->order_column) }}"
                  class="form-control"
                  oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');">
              </div>

              {{-- status --}}
              <div class="form-group">
                <label for="inputStatus">@lang('site.Status')</label>
                <select id="inputStatus" name="status" required class="form-control custom-select">
                  <option value='' selected disabled>@lang('site.Status')</option>
                  <option value="1" @if(old('status',$subscriptionType->status)==1) selected @endif>@lang('site.Active')</option>
                  <option value="0" @if(old('status',$subscriptionType->status)==0) selected @endif>@lang('site.In-Active')
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
