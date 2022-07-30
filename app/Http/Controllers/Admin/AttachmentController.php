<?php

namespace App\Http\Controllers\Admin;

use App\Models\Attachment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Interfaces\SchoolRepositoryInterface;
use App\Http\Controllers\Admin\BaseController;
use App\Interfaces\AttachmentRepositoryInterface;
use App\Http\Requests\Admin\AttachmentFormRequest;

class AttachmentController extends BaseController
{

  public function __construct(
    private AttachmentRepositoryInterface $attachmentRepository,
    private SchoolRepositoryInterface $schoolRepository
  ) {
    //create read update delete
    $this->middleware(['permission:read_attachments'])->only('index');
    $this->middleware(['permission:create_attachments'])->only('create');
    $this->middleware(['permission:update_attachments'])->only('edit');
    $this->middleware(['permission:delete_attachments'])->only('destroy');
  } //end of constructor

  public function index(Request $request)
  {
    session(['currentPage' => request('page', 1)]);

    $attachments = $this->attachmentRepository->getFilteredAttachments($request);

    return view('admin.attachments.index', compact('attachments'));
  } // end of index

  public function create(Request $request)
  {
    $schools = $this->schoolRepository->getAllSchools();
    return view('admin.attachments.create', compact('schools'));
  } //end of create

  public function show($attachment)
  {
    $attachment = $this->attachmentRepository->getAttachmentById($attachment);

    return view('admin.attachments.show', compact('attachment'));
  } //end of create

  public function store(AttachmentFormRequest $request)
  {
    $this->attachmentRepository->createAttachment($request);

    session()->flash('success', __('site.Data added successfully'));

    if ($request->continue) {
      return redirect()->route($this->mainRoutePrefix.'.attachments.index', ['page' => session('currentPage')]);
    }
    return redirect()->back();
  } //end of store

  public function edit($attachment)
  {

    $attachment = $this->attachmentRepository->getAttachmentById($attachment);
    $schools = $this->schoolRepository->getAllSchools();

    return view('admin.attachments.edit', compact('attachment', 'schools'));
  } //end of edit

  public function update(AttachmentFormRequest $request, Attachment $attachment)
  {
    $this->attachmentRepository->updateAttachment($request, $attachment);

    session()->flash('success', __('Data updated successfully'));

    if ($request->continue) {
      return redirect()->route($this->mainRoutePrefix.'.attachments.index', ['page' => session('currentPage')]);
    }
    return redirect()->back();
  } //end of update

  public function destroy(Attachment $attachment)
  {
    if (!$attachment) {
      return redirect()->back();
    }
    $this->attachmentRepository->deleteAttachment($attachment);

    session()->flash('success', __('Data deleted successfully'));
    return redirect()->route($this->mainRoutePrefix.'.attachments.index', ['page' => session('currentPage')]);
  } //end of destroy

}//end of controller
