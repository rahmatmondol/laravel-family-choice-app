@extends($masterLayout)
<?php
$page = 'transportations';
$title = __('site.Edit Transportation');
?>
@section('title_page')
    {{ $title }}
@endsection
@section('content')
    <!-- BEGIN: Breadcrumb -->
    <div class="mb-5">
        <ul class="m-0 p-0 list-none">
            <li class="inline-block relative top-[3px] text-base text-primary-500 font-Inter ">
                <a href="{{ route($mainRoutePrefix . '.dashboard') }}">
                    <iconify-icon icon="heroicons-outline:home"></iconify-icon>
                    <iconify-icon icon="heroicons-outline:chevron-right"
                        class="relative text-slate-500 text-sm rtl:rotate-180"></iconify-icon>
                </a>
            </li>
            <li class="inline-block relative text-sm text-slate-500 font-Inter dark:text-white">
                <a href="{{ route($mainRoutePrefix . '.transportations.index') }}">
                    @lang('site.PaidServices')
                    <iconify-icon icon="heroicons-outline:chevron-right"
                        class="relative text-slate-500 text-sm rtl:rotate-180"></iconify-icon>
                </a>
            </li>
            <li class="inline-block relative text-sm text-slate-500 font-Inter dark:text-white">
                {{ $title }}</li>
        </ul>
    </div>
    <!-- END: BreadCrumb -->
    <form method="post" action="{{ route($mainRoutePrefix . '.transportations.update', $transportation->id) }}"
        enctype="multipart/form-data">
        @csrf
        @method('put')
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
                                    value="{{ old($locale . '.title', $transportation->translate($locale)->title) }}"
                                    type="text" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="card">
                <div class="card-body flex flex-col p-6">
                    <div class="card-text h-full space-y-4">

                        {{-- price --}}
                        <div class="input-area">
                            <label>@lang('site.Price')</label>
                            <input type="text" name="price" value="{{ old('price', $transportation->price) }}"
                                class="form-control mt-2"
                                oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');">
                        </div>

                        {{-- order_column --}}
                        <div class="input-area">
                            <label>@lang('site.Order Item')</label>
                            <input type="text" name="order_column"
                                value="{{ old('order_column', $transportation->order_column) }}" class="form-control mt-2"
                                oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');">
                        </div>

                        {{-- status --}}
                        <div class="input-area">
                            <label for="inputStatus">@lang('site.Status')</label>
                            <select id="inputStatus" name="status" required class="form-control mt-2">
                                <option value='' selected disabled>@lang('site.Status')</option>
                                <option value="1" @if (old('status', $transportation->status) == 1) selected @endif>@lang('site.Active')
                                </option>
                                <option value="0" @if (old('status', $transportation->status) == 0) selected @endif>@lang('site.In-Active')
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
