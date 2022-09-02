<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function store(Request $request, $request_id)
    {
        $user_file = $request->userfile;
        $file_path = null;
        // if (is_uploaded_file($user_file) && !$user_file->hasMoved()) {
        //     $file_path = 'uploads/' . $user_file->store();
        // }

        if (!isset($request->message)) {
            return redirect('requests/' . $request_id);
        }

        Message::create([
            'text' => $request->message,
            'attach' => $file_path,
            'request_id' => $request_id,
            'created_by' => auth()->user()->id
        ]);

        return redirect('requests/' . $request_id);
    }
}
