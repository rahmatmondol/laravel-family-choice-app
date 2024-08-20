@extends($masterLayout)
<?php
$page = 'schools';
$title = __('site.Change Password');
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
                {{ $title }}</li>
        </ul>
    </div>
    <!-- END: BreadCrumb -->
    <form method="post" action="{{ route($mainRoutePrefix . '.profile.change-password-post') }}">
        @csrf
        @method('post')
        @include('admin.partials._errors')
        <div class="grid xl:grid-cols-2 grid-cols-1 gap-6">
            <div class="card">
                <div class="card-body flex flex-col p-6">
                    <div class="card-text h-full space-y-4">
                        {{-- current_password --}}
                        <div class="input-area">
                            <label>@lang('site.Current Password')</label>
                            <input type="password" name="current_password" class="form-control mt-2" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body flex flex-col p-6">
                    <div class="card-text h-full space-y-4">
                        {{-- passwrod --}}
                        <div class="input-area">
                            <label>@lang('site.Password')</label>
                            <input type="password" name="password" class="form-control mt-2" required>
                        </div>

                        {{-- password_confirmation --}}
                        <div class="input-area">
                            <label>@lang('site.Password Confirmation')</label>
                            <input type="password" name="password_confirmation" class="form-control mt-2" required>
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
