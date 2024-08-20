@extends($masterLayout)
<?php
$page = 'Discount Page';
$title = 'Add Discount';
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
                <a href="{{ route('school.discount.view') }}">
                    @lang('site.Discounts')
                    <iconify-icon icon="heroicons-outline:chevron-right"
                        class="relative text-slate-500 text-sm rtl:rotate-180"></iconify-icon>
                </a>
            </li>
            <li class="inline-block relative text-sm text-slate-500 font-Inter dark:text-white">
                {{ $title }}</li>
        </ul>
    </div>
    <!-- END: BreadCrumb -->
    <form method="post" action="{{ route('school.discount.store') }}" enctype="multipart/form-data" id="discountForm">
        @csrf
        @include('school.partials._errors')
        <input type="hidden" name="school_id" value="{{ $globalSchool->id }}">
        <div class="grid xl:grid-cols-2 grid-cols-1 gap-6">

            <div class="card">
                <div class="card-body flex flex-col p-6">
                    <div class="card-text h-full space-y-4">
                        {{-- Title --}}
                        <div class="input-area">
                            <label>Title</label>
                            <input type="text" name="title" value="{{ old('title') }}" class="form-control mt-2"
                                required>
                        </div>

                        {{-- Minimum Amount --}}
                        <div class="input-area">
                            <label>Minimum Amount</label>
                            <input type="number" name="minimum_amount" value="{{ old('minimum_amount') }}"
                                class="form-control mt-2" required min="0">
                        </div>

                        {{-- Starting Date --}}
                        <div class="input-area">
                            <label>Starting Date</label>
                            <input type="date" name="starting_date" value="{{ old('starting_date') }}"
                                class="form-control mt-2" required>
                        </div>

                        {{-- Ending Date --}}
                        <div class="input-area">
                            <label>Ending Date</label>
                            <input type="date" name="ending_date" value="{{ old('ending_date') }}"
                                class="form-control mt-2" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body flex flex-col p-6">

                    <div class="card-text h-full space-y-4">
                        {{-- Status --}}
                        <div class="input-area">
                            <label>Status</label>
                            <select name="status" class="form-control mt-2" required>
                                <option value='' selected disabled>Select Status</option>
                                <option value="1">Active</option>
                                <option value="0">In-Active</option>
                            </select>
                        </div>

                        {{-- Discount Type --}}
                        <div class="input-area">
                            <label>Discount Type</label>
                            <select name="discount_type" class="form-control mt-2" required id="discount_type">
                                <option value='' selected disabled>Select Discount Type</option>
                                <option value="percentage" @if (old('discount_type') == 'percentage') selected @endif>Percentage
                                </option>
                                <option value="fixed" @if (old('discount_type') == 'fixed') selected @endif>Fixed Amount
                                </option>
                            </select>
                        </div>

                        {{-- Percentage Discount --}}
                        <div class="input-area" id="percentage_discount_group" style="display: none;">
                            <label>Percentage Discount</label>
                            <input type="number" name="percentage_discount" value="{{ old('percentage_discount') }}"
                                class="form-control mt-2" min="0" max="100">
                        </div>

                        {{-- Discount Amount --}}
                        <div class="input-area" id="discount_amount_group" style="display: none;">
                            <label>Discount Amount</label>
                            <input type="number" name="discount_amount" value="{{ old('discount_amount') }}"
                                class="form-control mt-2">
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
            toggleDiscountFields(); // Initial call to set correct state on page load
        });
    </script>
@endsection

@push('scripts')
@endpush
