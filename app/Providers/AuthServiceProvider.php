<?php

namespace App\Providers;

use App\Models\Attachment;
use App\Models\Course;
use App\Models\Reservation;
use App\Models\School;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
  /**
   * The policy mappings for the application.
   *
   * @var array<class-string, class-string>
   */
  protected $policies = [
    // 'App\Models\Model' => 'App\Policies\ModelPolicy',
  ];

  /**
   * Register any authentication / authorization services.
   *
   * @return void
   */
  public function boot()
  {
    $this->registerPolicies();
    #courses
    Gate::define('show-course', function (School $school, $course) {
      if($course instanceof Model){
        $course = $course ;
      }else{
        $course = Course::findOrFail($course);
      }
      return $school->id === $course->school_id;
    });
    #attachments
    Gate::define('show-attachment', function (School $school, $attachment) {
      if($attachment instanceof Model){
        $attachment = $attachment ;
      }else{
        $attachment = Attachment::findOrFail($attachment);
      }
      return $school->id === $attachment->school_id;
    });
    #reservations
    Gate::define('show-reservation', function (School $school, $reservation) {
      if($reservation instanceof Model){
        $reservation = $reservation ;
      }else{
        $reservation = Reservation::findOrFail($reservation);
      }
      return $school->id === $reservation->school_id;
    });
  }
}
