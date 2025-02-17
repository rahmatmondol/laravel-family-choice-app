<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddFolderRequest;
use App\Http\Requests\Api\StoreDocumentRequest;
use App\Http\Requests\GetDocumentRequest;
use App\Http\Resources\DocumnetResource;
use App\Models\CustoemrDocument;
use App\Models\UserDocumentFolder;
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

        $data = CustoemrDocument::where('user_id', $user_id)->get();

        return $this->sendResponse(DocumnetResource::collection($data), 'success');
    }
    public function save(StoreDocumentRequest $request)
    {
        $user_id = Auth::user()->id;

        // Create a new CustomerDocument instance
        $document = new CustoemrDocument();
        $document->title = $request->title;
        $document->child_name = $request->child_name;
        $document->user_id = $user_id;
        $document->user_document_folder_id = $request->folder_id;
        $document->save();

        // Upload front side image if provided
        if ($request->hasFile('front_side')) {
            $front_side = $this->uploadFile($request->file('front_side'), 'document', ''); // Pass an empty string for the third argument
            $document->front_side = $front_side; // Store the front side image path in the database
            $document->save();
        }

        // Upload back side image if provided
        if ($request->hasFile('back_side')) {
            $back_side = $this->uploadFile($request->file('back_side'), 'document', ''); // Pass an empty string for the third argument
            $document->back_side = $back_side; // Store the back side image path in the database
            $document->save();
        }


        // Handle response appropriately
        return response()->json(['success' => true, 'message' => 'Document saved successfully', 'data' => $document], 200);
    }
    public function delete($id)
    {
        $document = CustoemrDocument::find($id);
        if (empty($document)) {
            return $this->sendResponse('', 'document is not exist');
        }
        $document->delete();
        return $this->sendResponse('', 'Document delete successfully');
    }


    public function saveFolder(Request $request)
    {
        // Validate the request
        $request->validate([
            'title' => 'required|string',
        ]);

        $customer = auth()->user();
        // Create and save the folder using the folders relationship
        $folder = $customer->folders()->create([
            'title' => $request->title,
        ]);

        return response()->json(['success' => true, 'message' => 'Folder saved successfully', 'data' => $folder], 200);
    }

    public function DeleteFolder($id)
    {
        $folder = UserDocumentFolder::find($id);
        $folder->delete();
        return response()->json(['success' => true, 'message' => 'Folder delete successfully'], 200);
    }

    public function getFolder()
    {
        $user_id = Auth::user()->id;
        $data = UserDocumentFolder::where('customer_id', $user_id)->with('documents')->get();
        return $this->sendResponse($data, 'success');
    }
}
