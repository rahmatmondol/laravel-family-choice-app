@extends($masterLayout)
<?php
$page = 'Boosting Page';
$title = 'Add Boost';
?>
@section('title_page')
    {{ $title }}
@endsection
@section('content')
    <!-- BEGIN: Breadcrumb -->
    <div class="mb-5">
        <ul class="m-0 p-0 list-none">
            <li class="inline-block relative top-[3px] text-base text-primary-500 font-Inter ">
                <a href="{{ route('school.dashboard') }}">
                    <iconify-icon icon="heroicons-outline:home"></iconify-icon>
                    <iconify-icon icon="heroicons-outline:chevron-right"
                        class="relative text-slate-500 text-sm rtl:rotate-180"></iconify-icon>
                </a>
            </li>
            <li class="inline-block relative text-sm text-slate-500 font-Inter dark:text-white">
                <a href="{{ route('school.boost.list') }}">
                    @lang('site.Boosts')
                    <iconify-icon icon="heroicons-outline:chevron-right"
                        class="relative text-slate-500 text-sm rtl:rotate-180"></iconify-icon>
                </a>
            </li>
            <li class="inline-block relative text-sm text-slate-500 font-Inter dark:text-white">
                {{ $title }}</li>
        </ul>
    </div>
    <!-- END: BreadCrumb -->
    <form method="post" action="{{ route('school.boost.store') }}" enctype="multipart/form-data">
        @csrf
        @method('post')
        @include('school.partials._errors')
        <input type="hidden" name="school_id" value="{{ $globalSchool->id }}">
        <div class="grid xl:grid-cols-2 grid-cols-1 gap-6">

            <div class="card">
                <div class="card-body flex flex-col p-6">
                    <div class="card-text h-full space-y-4">
                        {{-- City ID --}}
                        <div class="input-area">
                            <label>City</label>
                            <select name="city_id" class="form-control mt-2" required>
                                <option value='' selected disabled>Select City</option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city->id }}" @if (old('city_id') == $city->id) selected @endif>
                                        {{ $city->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Monthly Budget --}}
                        <div class="input-area">
                            <label>Monthly Budget</label>
                            <input type="number" name="monthly_budget" id="monthly_budget"
                                value="{{ old('monthly_budget') }}" class="form-control mt-2" required min="441">
                            <small id="budgetError" class="form-text text-danger" style="display: none; color:red">The monthly budget
                                must be between 441 AED and 2000 AED.</small>

                        </div>

                        {{-- Cost Per Click --}}
                        <div class="input-area">
                            <label>Cost per Click</label>
                            <select name="cost_per_click" id="cost_per_click" class="form-control mt-2" id="">
                                <option value="" selected disabled>Select</option>
                                @for ($i = 2.5; $i <= 6.5; $i += 0.5)
                                    <option value="{{ $i }}">{{ $i }} AED</option>
                                @endfor
                            </select>
                        </div>

                        {{-- Starting Date --}}
                        <div class="input-area">
                            <label>Staring Date</label>
                            <input type="date" name="starting" value="{{ old('starting') }}" class="form-control mt-2"
                                required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body flex flex-col p-6">

                    <div class="card-text h-full space-y-4">
                        {{-- Order Column --}}
                        <div class="form-group">
                            <h4 style="color: red;">Attention Please !!</h4>
                            <span class="form-text text-muted pt-2">Please enter maximum allowed value is between 100 -
                                400.</span>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const monthlyBudgetInput = document.getElementById('monthly_budget');
            const budgetError = document.getElementById('budgetError');

            monthlyBudgetInput.addEventListener('input', function() {
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
@endsection
