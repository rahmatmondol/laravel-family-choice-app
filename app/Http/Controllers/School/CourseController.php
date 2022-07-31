<?php

namespace App\Http\Controllers\School;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Interfaces\CourseRepositoryInterface;
use App\Http\Requests\Admin\CourseFormRequest;
use App\Http\Controllers\School\BaseController;

class CourseController extends BaseController
{

  public function __construct(
    private CourseRepositoryInterface $courseRepository,
  ) {
    parent::__construct();
  } //end of constructor

  public function index(Request $request)
  {
    session(['currentPage' => request('page', 1)]);

    $courses = $this->courseRepository->getFilteredCourses($request);

    return view($this->mainViewPrefix . '.courses.index', compact('courses'));
  } // end of index

  public function create(Request $request)
  {
    return view($this->mainViewPrefix . '.courses.create');
  } //end of create

  public function show($course)
  {
    if (!Gate::allows('show-course', $course)) {
      abort(403);
    }
    $course = $this->courseRepository->getCourseById($course);

    return view($this->mainViewPrefix . '.courses.show', compact('course'));
  } //end of create

  public function store(CourseFormRequest $request)
  {
    $this->courseRepository->createCourse($request);

    session()->flash('success', __('site.Data added successfully'));

    if ($request->continue) {
      return redirect()->route('school.courses.index', ['page' => session('currentPage')]);
    }
    return redirect()->back();
  } //end of store

  public function edit($course)
  {
    if (!Gate::allows('show-course', $course)) {
      abort(403);
    }

    $course = $this->courseRepository->getCourseById($course);

    return view($this->mainViewPrefix . '.courses.edit', compact('course'));
  } //end of edit

  public function update(CourseFormRequest $request, Course $course)
  {
    $this->courseRepository->updateCourse($request, $course);

    session()->flash('success', __('Data updated successfully'));

    if ($request->continue) {
      return redirect()->route('school.courses.index', ['page' => session('currentPage')]);
    }
    return redirect()->back();
  } //end of update

  public function destroy(Course $course)
  {
    if (!$course) {
      return redirect()->back();
    }
    $this->courseRepository->deleteCourse($course);

    session()->flash('success', __('Data deleted successfully'));
    return redirect()->route('school.courses.index', ['page' => session('currentPage')]);
  } //end of destroy

}//end of controller
