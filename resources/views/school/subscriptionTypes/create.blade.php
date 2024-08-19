@extends($masterLayout)
<?php
$page = 'subscriptionTypes';
$title = __('site.Create Subscription Type');
?>
@section('title_page')
    {{ $title }}
@endsection
@section('content')
    <!-- BEGIN: Breadcrumb -->
    <div class="mb-5">
        <ul class="m-0 p-0 list-none">
            <li class="inline-block relative top-[3px] text-base text-primary-500 font-Inter ">
                <a href="index.html">
                    <iconify-icon icon="heroicons-outline:home"></iconify-icon>
                    <iconify-icon icon="heroicons-outline:chevron-right"
                        class="relative text-slate-500 text-sm rtl:rotate-180"></iconify-icon>
                </a>
            </li>
            <li class="inline-block relative text-sm text-slate-500 font-Inter dark:text-white">
                <a href="{{ route($mainRoutePrefix . '.subscriptionTypes.index') }}">
                    @lang('site.SubscriptionTypes')
                    <iconify-icon icon="heroicons-outline:chevron-right"
                        class="relative text-slate-500 text-sm rtl:rotate-180"></iconify-icon>
                </a>
            </li>
            <li class="inline-block relative text-sm text-slate-500 font-Inter dark:text-white">
                {{ $title }}</li>
        </ul>
    </div>
    <!-- END: BreadCrumb -->
    <form method="post" action="{{ route($mainRoutePrefix . '.subscriptionTypes.store') }}" enctype="multipart/form-data">
        @csrf
        @method('post')
        @include('school.partials._errors')
        <input type="hidden" name="school_id" value="{{ $globalSchool->id }}">
        <div class="grid xl:grid-cols-2 grid-cols-1 gap-6">
            @foreach (LaravelLocalization::getSupportedLocales() as $locale => $properties)
                <div class="card">
                    <div class="card-body flex flex-col p-6">
                        <header
                            class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6">
                            <div class="flex-1">
                                <div class="card-title text-slate-900 dark:text-white">{{ $properties['name'] }}</div>
                            </div>
                        </header>
                        <div class="card-text h-full space-y-4">
                            {{-- title --}}
                            <div class="input-area">
                                <label class="form-label">@lang('site.' . $locale . '.Title')</label>
                                <input required="required" name="{{ $locale }}[title]"
                                    value="{{ old($locale . '.title') }}" type="text" class="form-control">
                            </div>

                            {{-- Appointment --}}
                            <div class="input-area">
                                <label class="form-label">@lang('site.' . $locale . '.Appointment')</label>
                                <input required="required" name="{{ $locale }}[appointment]"
                                    value="{{ old($locale . '.appointment') }}" type="text" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="card">
                <div class="card-body flex flex-col p-6">
                    <div class="card-text h-full space-y-4">

                        {{-- subscriptions --}}
                        <div class="input-area">
                            <label for="inputType">@lang('site.Subscriptions')</label>
                            <select name="subscription_id" class="form-control mt-2" required>
                                <option value='' selected disabled>@lang('site.Subscriptions')</option>
                                @foreach ($subscriptions as $subscription)
                                    <option value="{{ $subscription->id }}" @selected(old('subscription_id') == $subscription->id)>
                                        {{ $subscription->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- type --}}
                        <div class="input-area">
                            <label for="inputStatus">@lang('site.Status')</label>
                            <select id="inputStatus" name="type" required class="form-control custom-select mt-2">
                                <option value='' selected disabled>@lang('site.Status')</option>
                                @foreach (\App\Enums\SubscriptionTypes::cases() as $sub_type)
                                    <option value="{{ $sub_type->value }}" @selected(old('type') == $sub_type->value)>
                                        @lang('site.SubscriptionType.' . $sub_type->value)
                                    </option>
                                @endforeach
                            </select>
                        </div>


                        {{-- number_of_days --}}
                        <div class="input-area">
                            <label for="inputStatus">@lang('site.Number Of Days')</label>
                            <select id="inputStatus" name="number_of_days" required class="form-control mt-2">
                                <option value='' selected disabled>@lang('site.Number Of Days')</option>
                                @for ($i = 1; $i <= 7; $i++)
                                    <option value="{{ $i }}" @selected(old('number_of_days') == $i)>{{ $i }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        {{-- price --}}
                        <div class="input-area">
                            <label>@lang('site.Price')</label>
                            <input type="text" name="price" value="{{ old('price') }}" class="form-control"
                                oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');">
                        </div>


                        {{-- order_column --}}
                        <div class="input-area">
                            <label>@lang('site.Order Item')</label>
                            <input type="text" name="order_column" value="{{ old('order_column') }}"
                                class="form-control mt-2"
                                oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');">
                        </div>

                        {{-- status --}}
                        <div class="input-area">
                            <label for="inputStatus">@lang('site.Status')</label>
                            <select id="inputStatus" name="status" required class="form-control custom-select mt-2">
                                <option value='' selected disabled>@lang('site.Status')</option>
                                <option value="1" @if (old('status') == 1) selected @endif>@lang('site.Active')
                                </option>
                                <option value="0" @if (old('status') == 0) selected @endif>@lang('site.In-Active')
                                </option>
                            </select>
                        </div>

                    </div>
                </div>
            </div>

        </div>
        {{-- save --}}
        <div class="grid xl:grid-cols-1 grid-cols-1 gap-6 mt-6">
            <div class="card rounded-md bg-white dark:bg-slate-800 lg:h-full shadow-base">
                <div class="card-body flex flex-col p-6">
                    <div class="card-text h-full space-y-6">
                        <div class="input-area text-center">
                            <button class="btn inline-flex justify-center btn-primary" type="submit" name='continue'
                                value='continue'><i class="fas fa-save"></i>
                                @lang('site.Save & Continue')</button>
                            <button class="btn inline-flex justify-center btn-primary" type="submit"><i
                                    class="fas fa-save"></i>
                                @lang('site.Save')</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
