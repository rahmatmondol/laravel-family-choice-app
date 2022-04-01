<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   *
   * @return void
   */
  public function register()
  {
    //
  }

  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot()
  {
    // fix defaultStringLength
    Schema::defaultStringLength(191);
    Paginator::useBootstrap();

    // Model::preventLazyLoading(!app()->isProduction());

    // View::creator('*', function ($view) {

    //   $view->with([
    //     'globalCustomer' => getCustomer(),
    //   ]);
    // });

    // View::composer('frontend.components.app.header', 'App\Http\View\Composers\CategoryList');
    // View::composer('frontend.components.app.footer', 'App\Http\View\Composers\SocialMediaList');
    // View::composer('frontend.components.app.footer', 'App\Http\View\Composers\FooterList');

    #admin dashboard
    View::creator('admin/*', function ($view) {

      $view->with([
        'globalAdmin' => getAdmin(),
      ]);
    });

    // #admin dashboard
    // View::creator('dashboard/*', function ($view) {

    //   $view->with([
    //     'totalOrders' => Order::count(),
    //     'totalPenddingOrders' => Order::where('status', 'inPreparation')->count(),
    //     'totalInboxes' => Inbox::count(),
    //     'totalInActiveInboxes' => Inbox::where('status', 0)->count(),
    //     'totalComplaints' => Complaint::count(),
    //     'totalInActiveComplaints' => Complaint::where('status', 0)->count(),
    //   ]);
    // });
  }
}
