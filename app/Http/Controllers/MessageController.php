<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMessageRequest;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class MessageController extends Controller
{
    public function __construct(
        Message $message
    ) {
        $this->message = $message;
    }

    public function store(StoreMessageRequest $request, int $requestId)
    {
        $filePath = $this->storeFile($request->file('userfile')) ?? null;

        if (!isset($request->message) && !$filePath) {
            return redirect('requests/' . $requestId);
        }

        $this->message->create([
            'text' => $request->message,
            'attach' => $filePath,
            'request_id' => $requestId,
            'created_by' => auth()->user()->id
        ]);

        return redirect('requests/' . $requestId);
    }

    private function storeFile(UploadedFile $file = null)
    {
        if (!$file) {
            return null;
        }

        $fileName = time() . '.' . $file->getClientOriginalExtension();

        Storage::disk('local')
            ->put('uploaded-files/' . $fileName, file_get_contents(($file)));


        return 'uploaded-files/' . $fileName;
    }

    public function downloadFile(Request $request)
    {
        return Storage::download($request->file_uri);
    }
}
