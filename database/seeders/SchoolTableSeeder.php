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
use App\Models\Subscription;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

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
    $types = Type::get()->pluck('id')->toArray();
    for ($i = 0; $i < 50; $i++) {

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

      for ($c = 0; $c < 20; $c++) {
        $school->courses()->create([
          'ar' => ['title' => '-دورة تعديل السلوك' . $c, 'short_description' => 'دورة صيفية', 'description' => "من عمر 10 سنين : 15 سنة"],
          'en' => ['title' => '-دورة تعديل السلوك' . $c, 'short_description' => 'دورة صيفية', 'description' => "من عمر 10 سنين : 15 سنة"],
          'status' => 1,
          'school_id' => $school->id,
          'subscription_id' => $subscriptions[array_rand($subscriptions)],
          'from_date' => '2022-10-10',
          'to_date' => '2022-10-20',
          'image' => 'default.png',
        ]);
      }

      $school->educationalSubjects()->attach(EducationalSubject::pluck('id')->toArray());
      $school->schoolTypes()->attach(SchoolType::pluck('id')->toArray());
      $school->educationTypes()->attach(EducationType::pluck('id')->toArray());

      // if school attach grades
      if (!$school->is_nursery_type) {

        foreach (Grade::pluck('id')->toArray() as $grade) {
          $school->grades()->attach($grade, [
            'fees' => 1000,
            'status' => 1
          ]);
        }
      }

      // if nursery attach subscriptions
      if ($school->is_nursery_type) {

        foreach ($subscriptions as $subscription) {
          $school->subscriptions()->attach($subscription, [
            'status' => 1
          ]);
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
