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
use App\Interfaces\CustomerRepositoryInterface;
use App\Interfaces\AttachmentRepositoryInterface;
use App\Interfaces\SchoolTypeRepositoryInterface;
use App\Interfaces\UserManualRepositoryInterface;
use App\Interfaces\ReservationRepositoryInterface;
use App\Repositories\EducationalSubjectRepository;
use App\Interfaces\EducationTypeRepositoryInterface;
use App\Interfaces\EducationalSubjectRepositoryInterface;

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
