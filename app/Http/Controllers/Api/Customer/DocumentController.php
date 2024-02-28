<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreDocumentRequest;
use App\Models\CustoemrDocument;
use App\Traits\ResponseTrait;
use App\Traits\UploadFileTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    use UploadFileTrait;
    use ResponseTrait;
    //
    public function view()
    {
        $user_id = Auth::user()->id;

        $data = CustoemrDocument::where('user_id',$user_id)->get();

        return $this->sendResponse();
    }
    public function save(StoreDocumentRequest $request)
    {
        $user_id = Auth::user()->id;

        // Create a new CustomerDocument instance
        $document = new CustoemrDocument();
        $document->user_id = $user_id;
        $document->save();

        // Upload front side image if provided
        if ($request->hasFile('front_side')) {
            $front_side = $this->uploadFile($request->file('front_side'), 'document', ''); // Pass an empty string for the third argument
            $document->front_side = $front_side; // Store the front side image path in the database
        }

        // Upload back side image if provided
        if ($request->hasFile('back_side')) {
            $back_side = $this->uploadFile($request->file('back_side'), 'document', ''); // Pass an empty string for the third argument
            $document->back_side = $back_side; // Store the back side image path in the database
        }

        // Save the changes to the CustomerDocument instance
        $document->save();

        // Handle response appropriately
        return response()->json(['success' => true, 'message' => 'Document saved successfully'], 200);
    }

}
