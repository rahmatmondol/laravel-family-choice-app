<?php

namespace App\Providers;

use App\Repositories\CityRepository;
use App\Repositories\RoleRepository;
use App\Repositories\TypeRepository;
use App\Repositories\AdminRepository;
use App\Repositories\GradeRepository;
use App\Repositories\CourseRepository;
use App\Repositories\SchoolRepository;
use App\Repositories\SliderRepository;
use App\Repositories\ServiceRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\CustomerRepository;
use App\Repositories\AttachmentRepository;
use App\Repositories\SchoolTypeRepository;
use App\Repositories\UserManualRepository;
use App\Interfaces\CityRepositoryInterface;
use App\Interfaces\RoleRepositoryInterface;
use App\Interfaces\TypeRepositoryInterface;
use App\Repositories\ReservationRepository;
use App\Interfaces\AdminRepositoryInterface;
use App\Interfaces\GradeRepositoryInterface;
use App\Interfaces\CourseRepositoryInterface;
use App\Interfaces\SchoolRepositoryInterface;
use App\Interfaces\SliderRepositoryInterface;
use App\Repositories\EducationTypeRepository;
use App\Interfaces\ServiceRepositoryInterface;
use App\Interfaces\CustomerRepositoryInterface;
use App\Interfaces\AttachmentRepositoryInterface;
use App\Interfaces\Customer\ReservationRepositoryInterface as CustomerReservationRepositoryInterface;
use App\Interfaces\Customer\WalletRepositoryInterface;
use App\Interfaces\SchoolTypeRepositoryInterface;
use App\Interfaces\UserManualRepositoryInterface;
use App\Interfaces\ReservationRepositoryInterface;
use App\Repositories\EducationalSubjectRepository;
use App\Interfaces\EducationTypeRepositoryInterface;
use App\Interfaces\EducationalSubjectRepositoryInterface;
use App\Interfaces\GradeFeesRepositoryInterface;
use App\Interfaces\NurseryFeesRepositoryInterface;
use App\Interfaces\PaidServiceRepositoryInterface;
use App\Interfaces\ReservationLogRepositoryInterface;
use App\Interfaces\SubscriptionRepositoryInterface;
use App\Interfaces\SubscriptionTypeRepositoryInterface;
use App\Interfaces\TransportationRepositoryInterface;
use App\Repositories\Customer\ReservationRepository as CustomerReservationRepository;
use App\Repositories\Customer\WalletRepository;
use App\Repositories\GradeFeesRepository;
use App\Repositories\NurseryFeesRepository;
use App\Repositories\PaidServiceRepository;
use App\Repositories\ReservationLogRepository;
use App\Repositories\SubscriptionRepository;
use App\Repositories\SubscriptionTypeRepository;
use App\Repositories\TransportationRepository;

class RepositoryServiceProvider extends ServiceProvider
{
  /**
   * Register services.
   *
   * @return void
   */
  public function register()
  {
    $this->app->bind(AdminRepositoryInterface::class, AdminRepository::class);
    $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
    $this->app->bind(CustomerRepositoryInterface::class, CustomerRepository::class);
    $this->app->bind(SliderRepositoryInterface::class, SliderRepository::class);
    $this->app->bind(GradeRepositoryInterface::class, GradeRepository::class);
    $this->app->bind(CityRepositoryInterface::class, CityRepository::class);
    $this->app->bind(EducationalSubjectRepositoryInterface::class, EducationalSubjectRepository::class);
    $this->app->bind(EducationTypeRepositoryInterface::class, EducationTypeRepository::class);
    $this->app->bind(SchoolTypeRepositoryInterface::class, SchoolTypeRepository::class);
    $this->app->bind(TypeRepositoryInterface::class, TypeRepository::class);
    $this->app->bind(SchoolRepositoryInterface::class, SchoolRepository::class);
    $this->app->bind(CourseRepositoryInterface::class, CourseRepository::class);
    $this->app->bind(UserManualRepositoryInterface::class, UserManualRepository::class);
    $this->app->bind(AttachmentRepositoryInterface::class, AttachmentRepository::class);
    $this->app->bind(ReservationRepositoryInterface::class, ReservationRepository::class);
    $this->app->bind(ServiceRepositoryInterface::class, ServiceRepository::class);
    $this->app->bind(ReservationLogRepositoryInterface::class, ReservationLogRepository::class);
    $this->app->bind(CustomerReservationRepositoryInterface::class, CustomerReservationRepository::class);
    $this->app->bind(SubscriptionRepositoryInterface::class, SubscriptionRepository::class);
    $this->app->bind(SubscriptionTypeRepositoryInterface::class, SubscriptionTypeRepository::class);
    $this->app->bind(NurseryFeesRepositoryInterface::class, NurseryFeesRepository::class);
    $this->app->bind(GradeFeesRepositoryInterface::class, GradeFeesRepository::class);
    $this->app->bind(PaidServiceRepositoryInterface::class, PaidServiceRepository::class);
    $this->app->bind(TransportationRepositoryInterface::class, TransportationRepository::class);
    $this->app->bind(WalletRepositoryInterface::class, WalletRepository::class);

  }
  /**
   * Bootstrap services.
   *
   * @return void
   */
  public function boot()
  {
    //
  }
}
