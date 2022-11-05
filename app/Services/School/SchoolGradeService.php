<?php

namespace App\Services\School;

use App\Models\SchoolGrade;
use Illuminate\Support\Facades\DB;

class SchoolGradeService
{
  public static function getSchoolGrades($school)
  {
    return $school->grades;
  }

  public static function getSchoolGrade($school, $grade)
  {
    return SchoolGrade::where([['school_id', $school->id], ['grade_id', $grade->id]])->firstOrFail();
  }

  public static function storeSchoolGrade($request,$school_id)
  {
    DB::table('school_grade')->updateOrInsert(['grade_id' => $request->grade_id, 'school_id' => $school_id], [
      'fees' => $request->fees,
      'administrative_expenses' => $request->administrative_expenses,
      'status' => $request->status
    ]);
  }

  public static function updateSchoolGrade($request, $school, $grade)
  {
    DB::table('school_grade')->updateOrInsert(['grade_id' => $grade->id, 'school_id' => $school->id], [
      'fees' => $request->fees,
      'administrative_expenses' => $request->administrative_expenses,
      'status' => $request->status
    ]);
  }

  public static function deleteSchoolGrade($school, $grade)
  {
    SchoolGrade::where([['school_id', $school->id], ['grade_id', $grade->id]])->delete();
  }
}
