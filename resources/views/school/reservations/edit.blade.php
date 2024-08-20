@extends($masterLayout)
<?php
$page = 'reservations';
$title = __('site.Edit Reservation');
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
                <a href="{{ route($mainRoutePrefix . '.reservations.index') }}">
                    @lang('site.Reservations')
                    <iconify-icon icon="heroicons-outline:chevron-right"
                        class="relative text-slate-500 text-sm rtl:rotate-180"></iconify-icon>
                </a>
            </li>
            <li class="inline-block relative text-sm text-slate-500 font-Inter dark:text-white">
                {{ $title }}</li>
        </ul>
    </div>
    <!-- END: BreadCrumb -->
    <form method="post" action="{{ route($mainRoutePrefix . '.reservations.update', $reservation->id) }}"
        enctype="multipart/form-data">
        @csrf
        @method('put')
        @include('admin.partials._errors')
        <div class="grid xl:grid-cols-2 grid-cols-1 gap-6">
            <div class="card">
                <div class="card-body flex flex-col p-6">
                    <div class="card-text h-full space-y-4">
                        {{-- status --}}
                        <div class="input-area">
                            <label for="inputStatus">@lang('site.Status')</label>
                            <select id="inputStatus" name="status" required class="form-control mt-2">
                                <option value='' selected disabled>@lang('site.Status')</option>
                                @foreach (\App\Enums\ReservationStatus::cases() as $reservationtStatus)
                                    <option value="{{ $reservationtStatus->value }}" @selected(old('status', $reservation->status) == $reservationtStatus->value)>
                                        @lang('site.reservation_status.' . $reservationtStatus->value)
                                    </option>
                                @endforeach
                                </option>
                            </select>
                        </div>

                        {{-- reason_of_refuse --}}
                        <div class="input-area">
                            <label for="inputName"> @lang('site.Reason of refuse') </label>
                            <input type="text" name="reason_of_refuse"
                                value="{{ old('reason_of_refuse', $reservation->reason_of_refuse) }}" class="form-control mt-2">
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
