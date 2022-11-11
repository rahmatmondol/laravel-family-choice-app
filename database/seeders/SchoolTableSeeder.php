<?php

namespace Database\Seeders;

use App\Models\Type;
use App\Models\Course;
use App\Models\School;
use App\Models\Attachment;
use App\Models\SchoolType;
use App\Models\SchoolImage;
use App\Models\EducationType;
use Illuminate\Database\Seeder;
use App\Models\EducationalSubject;
use App\Models\Grade;
use App\Models\GradeFees;
use App\Models\NurseryFees;
use App\Models\PaidService;
use App\Models\Service;
use App\Models\Subscription;
use App\Models\SubscriptionType;
use App\Models\Transportation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Arr;

class SchoolTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $description = "Qimam Al-Hayat Schools is one of the oldest international schools in the center of Riyadh, and it has a group of experienced and competent people, including administrators, teachers, teachers, supervisors and supervisors.

    Qimam Al-Hayat Schools have a clear vision and a specific goal, which is (graduating a generation capable of leadership). In order to implement and reach the goal and vision, the administration was required to promote and use additional values ​​and enablers to move at a clear and steady pace to achieve the goal.

    The school sought to provide a distinct educational environment and climate for students and provided them with all modern educational means that help the teacher and the student to receive, learn and be creative, as well as the stadiums, sports and entertainment arenas.

    Qimam Al-Hayat Global Schools are concerned with educational quality, not educational quantities, and using mechanisms to develop curricula according to the studied vision and policy, and quoting the successful experiences of the West in the whole world.

    In addition to the advanced curricula, schools have added various programs to develop students' skills and abilities, such as programs of mental arithmetic, speech, dialogue, speech, extra-curricular activities, and attention to physical health through sports academies.

    Schools also seek to deny the negative image of international schools that they are not interested in the Arabic language or the Qur’an, by promoting interest in the language and Quran memorization programs through the curriculum, as well as additional classes after the end of the school day.

    The schools have opened all communication channels to facilitate the arrival of the guardian and the speed of providing the service as soon as possible through the website, social media pages, the class dojo program, official e-mails and student affairs.-";
    $address = " Jeddah saudia arabia address-";
    $title = "Rowad Al Khaleej International Schools - ";

    $subscriptions = Subscription::get()->pluck('id')->toArray();
    $grades = Grade::get()->pluck('id')->toArray();
    $types = Type::get()->pluck('id')->toArray();
    $prices = [1200, 1500, 1400];
    $courses_types = ['summery', 'wintry'];
    $subscription_time_types = ['part_time', 'full_time'];
    for ($i = 1; $i < 6; $i++) {

      $school = School::create([
        'ar' => ['title' => $title . $i, 'address' => $address . $i, 'description' => $description . $i],
        'en' => ['title' => $title . $i, 'address' => $address . $i, 'description' => $description . $i],
        'status' => 1,
        'phone' => \rand(5, 10) . \rand(5, 10) . '015254' . $i * \rand(5, 10),
        'whatsapp' =>  \rand(5, 10) . \rand(5, 10) . '012254' . $i * \rand(5, 10),
        'email' => 'info' . \rand(5, 100) . \rand(5, 100) . \rand(5, 100) . '@gmail.com',
        'available_seats' => $available_seats = \rand(5, 500),
        'total_seats' => $available_seats + 100,
        'review' => \rand(1, 5),
        'count_reviews' => \rand(10, 50),
        'password' => bcrypt(123456),
        'type_id' => $types[array_rand($types)],
        'image' => 'default.png',
        'lat' => '24.71429' . \rand(5, 10) . \rand(5, 10) . \rand(5, 10),
        'lng' => '46.67091' . \rand(5, 10) . \rand(5, 10) . \rand(5, 10),
      ]);

      for ($k = 0; $k < 4; $k++) {
        $school->schoolImages()->create([
          'school_id' => $school->id,
          'image' => 'default.png',
        ]);
      }

      $school->educationalSubjects()->attach(EducationalSubject::pluck('id')->toArray());
      $school->schoolTypes()->attach(SchoolType::pluck('id')->toArray());
      $school->educationTypes()->attach(EducationType::pluck('id')->toArray());
      $school->services()->attach(Service::pluck('id')->toArray());

      // transportations
      Transportation::create([
        'ar' => ['title' => 'بدون مواصلات'],
        'en' => ['title' => 'No Transportation'],
        'status' => 1,
        'price' => 0,
        'school_id' => $school->id,
      ]);

      Transportation::create([
        'ar' => ['title' => 'اشتراك ذهاب فقط'],
        'en' => ['title' => 'Only Going'],
        'status' => 1,
        'price' =>1000,
        'school_id' => $school->id,
      ]);

      Transportation::create([
        'ar' => ['title' => 'اشتراك عوده فقط'],
        'en' => ['title' => 'Only Returns'],
        'status' => 1,
        'price' =>1000,
        'school_id' => $school->id,
      ]);

      Transportation::create([
        'ar' => ['title' => 'اشتراك ذهاب وعودة '],
        'en' => ['title' => 'Both Going and return'],
        'status' => 1,
        'price' => 1500,
        'school_id' => $school->id,
      ]);

      // add paid services
      $data = [
        [
          'ar' => ['title' => "اشتراك حمام سباحة"],
          'en' => ['title' => 'pool subscription'],
          'price' => $prices[array_rand($prices)],
          'school_id' => $school->id,
        ],
        [
          'ar' => ['title' => "رسوم الملابس والادوات المدرسية"],
          'en' => ['title' => 'School uniforms and supplies'],
          'price' => $prices[array_rand($prices)],
          'school_id' => $school->id,
        ],
        [
          'ar' => ['title' => "رعاية الاطفال اقل من عامين"],
          'en' => ['title' => 'Caring for children under two years old'],
          'price' => $prices[array_rand($prices)],
          'school_id' => $school->id,
        ],
      ];
      foreach ($data as $item) {
        PaidService::create($item);
      }


      // if school attach grades
      if ($school->is_school_type && isset($grades)) {
        $school->grades()->syncWithPivotValues($grades, ['status' => 1]);
        foreach ($grades as $key => $grade) {
          GradeFees::create([
            'ar' => ['title' => " ${key} مصاريف ادارية"],
            'en' => ['title' => " ${key} administrative expenses"],
            'price' => $prices[array_rand($prices)],
            'grade_id' => $grade,
            'school_id' => $school->id,
          ]);
        }
      }

      // if nursery attach subscriptions
      if ($school->is_nursery_type) {
        for ($j = 0; $j < 5; $j++) {
          NurseryFees::create([
            'ar' => ['title' => " ${j} مصاريف ادارية"],
            'en' => ['title' => " ${j} administrative expenses"],
            'price' => $prices[array_rand($prices)],
            'school_id' => $school->id,
          ]);
        }
        for ($c = 0; $c < 20; $c++) {
          $school->courses()->create([
            'ar' => ['title' => '-دورة تعديل السلوك' . $c, 'short_description' => 'دورة صيفية', 'description' => "من عمر 10 سنين : 15 سنة"],
            'en' => ['title' => '-دورة تعديل السلوك' . $c, 'short_description' => 'دورة صيفية', 'description' => "من عمر 10 سنين : 15 سنة"],
            'status' => 1,
            'type' => $courses_types[array_rand($courses_types)],
            'school_id' => $school->id,
            'subscription_id' => $subscriptions[array_rand($subscriptions)],
            'from_date' => '2022-10-10',
            'to_date' => '2022-10-20',
            'image' => 'default.png',
          ]);
        }

        if ($subscriptions)
          $school->subscriptions()->syncWithPivotValues($subscriptions, ['status' => 1]);

        foreach ($subscriptions as $subscription) {
          $data = [
            [
              'ar' => ['title' => 'حضانة صباحية', 'appointment' => 'من 8 ص الي 11 م'],
              'en' => ['title' => "morning nursery", 'appointment' => 'from 8 am to 11 am'],
              'number_of_days' => rand(3, 5),
              'price' => $prices[array_rand($prices)],
              'type' => $subscription_time_types[array_rand($subscription_time_types)],
              'school_id' => $school->id,
              'subscription_id' => $subscription,
            ],
            [
              'ar' => ['title' => 'حضانة صباحية', 'appointment' => 'من 7 ص الي 10 م'],
              'en' => ['title' => "morning nursery", 'appointment' => 'from 10 am to 7 am'],
              'number_of_days' => rand(3, 5),
              'price' => $prices[array_rand($prices)],
              'type' => $subscription_time_types[array_rand($subscription_time_types)],
              'school_id' => $school->id,
              'subscription_id' => $subscription,
            ],
            [
              'ar' => ['title' => 'حضانة مسائية', 'appointment' => 'من 12 م الي 4 م'],
              'en' => ['title' => "evening nursery", 'appointment' => 'from 12 pm to 4 pm'],
              'number_of_days' => rand(3, 5),
              'price' => $prices[array_rand($prices)],
              'type' => $subscription_time_types[array_rand($subscription_time_types)],
              'school_id' => $school->id,
              'subscription_id' => $subscription,
            ],
          ];
          foreach ($data as $item) {
            SubscriptionType::create($item);
          }
        }
      }

      Attachment::create([
        'ar' => ['title' => 'صورة الطالب'],
        'en' => ['title' => 'student image'],
        'status' => 1,
        'school_id' => $school->id
      ]);

      Attachment::create([
        'ar' => ['title' => 'شهادة الميلاد'],
        'en' => ['title' => 'birth certificate'],
        'status' => 1,
        'school_id' => $school->id
      ]);

      Attachment::create([
        'ar' => ['title' => 'البطاقة الصحية'],
        'en' => ['title' => 'health card'],
        'status' => 1,
        'school_id' => $school->id
      ]);
    } // end for
  }
}
