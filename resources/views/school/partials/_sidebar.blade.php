<!-- BEGIN: Sidebar -->
<div class="sidebar-wrapper group">
    <div id="bodyOverlay" class="w-screen h-screen fixed top-0 bg-slate-900 bg-opacity-50 backdrop-blur-sm z-10 hidden">
    </div>
    <div class="logo-segment">
        <a class="flex items-center" href="{{ route('home') }}">
            <img src="" class="black_logo" alt="">
            <img src="" class="white_logo" alt="">
            <span
                class="ltr:ml-3 rtl:mr-3 text-xl font-Inter font-bold text-slate-900 dark:text-white">{{ appName() }}</span>
        </a>

        <!-- Sidebar Type Button -->
        <div id="sidebar_type" class="cursor-pointer text-slate-900 dark:text-white text-lg">
            <span class="sidebarDotIcon extend-icon cursor-pointer text-slate-900 dark:text-white text-2xl">
                <div
                    class="h-4 w-4 border-[1.5px] border-slate-900 dark:border-slate-700 rounded-full transition-all duration-150 ring-2 ring-inset ring-offset-4 ring-black-900 dark:ring-slate-400 bg-slate-900 dark:bg-slate-400 dark:ring-offset-slate-700">
                </div>
            </span>
            <span class="sidebarDotIcon collapsed-icon cursor-pointer text-slate-900 dark:text-white text-2xl">
                <div
                    class="h-4 w-4 border-[1.5px] border-slate-900 dark:border-slate-700 rounded-full transition-all duration-150">
                </div>
            </span>
        </div>
        <button class="sidebarCloseIcon text-2xl">
            <iconify-icon class="text-slate-900 dark:text-slate-200" icon="clarity:window-close-line"></iconify-icon>
        </button>
    </div>

    <div id="nav_shadow"
        class="nav_shadow h-[60px] absolute top-[80px] nav-shadow z-[1] w-full transition-all duration-200 pointer-events-none
    opacity-0">
    </div>
    <div class="sidebar-menus bg-white dark:bg-slate-800 py-2 px-4 h-[calc(100%-80px)] overflow-y-auto z-50"
        id="sidebar_menus">
        <ul class="sidebar-menu">
            <li class="">
                <a href="{{ route($mainRoutePrefix . '.dashboard') }}"
                    class="navItem @if ($page == 'dashboard') active @endif">
                    <span class="flex items-center">
                        <iconify-icon class=" nav-icon" icon="heroicons-outline:home"></iconify-icon>
                        <span> {{ ucfirst(__('site.Dashboard')) }}</span>
                    </span>
                </a>
            </li>

            <li class="">
                <a href="{{ route($mainRoutePrefix . '.profile.show') }}"
                    class="navItem @if ($page == 'profile') active @endif">
                    <span class="flex items-center">
                        <iconify-icon class=" nav-icon" icon="heroicons-outline:user"></iconify-icon>
                        <span> {{ ucfirst(__('site.Profile')) }}</span>
                    </span>
                </a>
            </li>
            @if ($globalSchool->is_nursery_type)
                <li class="">
                    <a href="{{ route($mainRoutePrefix . '.courses.index') }}"
                        class="navItem @if ($page == 'courses') active @endif">
                        <span class="flex items-center">
                            <iconify-icon class=" nav-icon" icon="heroicons:academic-cap"></iconify-icon>
                            <span>{{ ucfirst(__('site.Courses')) }}</span>
                        </span>
                    </a>
                </li>
                <li class="">
                    <a href="{{ route($mainRoutePrefix . '.subscriptionTypes.index') }}"
                        class="navItem @if ($page == 'subscriptionTypes') active @endif">
                        <span class="flex items-center">
                            <iconify-icon class=" nav-icon" icon="heroicons-outline:list-bullet"></iconify-icon>
                            <span> {{ ucfirst(__('site.SubscriptionTypes')) }}</span>
                        </span>
                    </a>
                </li>
                <li class="">
                    <a href="{{ route($mainRoutePrefix . '.nurseryFees.index') }}"
                        class="navItem @if ($page == 'nurseryFees') active @endif">
                        <span class="flex items-center">
                            <iconify-icon class=" nav-icon" icon="heroicons-outline:banknotes"></iconify-icon>
                            <span> {{ ucfirst(__('site.NurseryFees')) }}</span>
                        </span>
                    </a>
                </li>
            @endif

            @if ($globalSchool->is_school_type)
                <li class="">
                    <a href="{{ route($mainRoutePrefix . '.grades.index') }}"
                        class="navItem @if ($page == 'grades') active @endif">
                        <span class="flex items-center">
                            <iconify-icon class=" nav-icon" icon="heroicons-outline:academic-cap"></iconify-icon>
                            <span> {{ ucfirst(__('site.Grades')) }}</span>
                        </span>
                    </a>
                </li>
                <li class="">
                    <a href="{{ route($mainRoutePrefix . '.gradeFees.index') }}"
                        class="navItem @if ($page == 'gradeFees') active @endif">
                        <span class="flex items-center">
                            <iconify-icon class=" nav-icon" icon="heroicons-outline:credit-card"></iconify-icon>
                            <span> {{ ucfirst(__('site.GradeFees')) }}</span>
                        </span>
                    </a>
                </li>
            @endif

            @foreach ($sideBarItems as $item)
                <li class="">
                    <a href="{{ route('school.' . $item . '.index') }}"
                        class="navItem @if ($page == $item) active @endif">
                        <span class="flex items-center">
                            <iconify-icon class=" nav-icon" icon="heroicons-outline:adjustments-horizontal"></iconify-icon>
                            <span> {{ __('site.' . ucfirst($item)) }}</span>
                        </span>
                    </a>
                </li>
            @endforeach

            <li class="">
                <a href="{{ route($mainRoutePrefix . '.profile.change-password') }}"
                    class="navItem @if (Route::currentRouteName() == 'school.profile.change-password') active @endif">
                    <span class="flex items-center">
                        <iconify-icon class=" nav-icon" icon="heroicons-outline:key"></iconify-icon>
                        <span>
                            {{ ucfirst(__('site.Change Password')) }}
                        </span>
                    </span>
                </a>
            </li>

            <li class="">
                <a href="{{ route($mainRoutePrefix . '.reservation-logs') }}"
                    class="navItem @if ($page == 'logs') active @endif">
                    <span class="flex items-center">
                        <iconify-icon class=" nav-icon" icon="heroicons-outline:clipboard-document-list"></iconify-icon>
                        <span>
                            {{ ucfirst(__('Reservation.Logs')) }}
                        </span>
                    </span>
                </a>
            </li>

            <li class="">
                <a href="{{ route($mainRoutePrefix . '.payments.index') }}"
                    class="navItem @if ($page == 'payments') active @endif">
                    <span class="flex items-center">
                        <iconify-icon class=" nav-icon" icon="heroicons-outline:credit-card"></iconify-icon>
                        <span>
                            {{ ucfirst(__('site.Payments')) }}
                        </span>
                    </span>
                </a>
            </li>
            <li class="">
                <a href="{{ route($mainRoutePrefix . '.discount.view') }}"
                    class="navItem @if ($page == 'Discount') active @endif">
                    <span class="flex items-center">
                        <iconify-icon class=" nav-icon" icon="heroicons-outline:receipt-percent"></iconify-icon>
                        <span>
                            Discount
                        </span>
                    </span>
                </a>
            </li>
            <li class="">
                <a href="{{ route($mainRoutePrefix . '.boost.list') }}"
                    class="navItem @if ($page == 'boost page') active @endif">
                    <span class="flex items-center">
                        <iconify-icon class=" nav-icon" icon="heroicons-outline:bolt"></iconify-icon>
                        <span>
                            Boost School
                        </span>
                    </span>
                </a>
            </li>
        </ul>
    </div>
</div>
<!-- End: Sidebar -->
