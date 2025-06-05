<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class AttachmentController extends Controller
{
    public function show(Attachment $attachment)
    {
        return Response::file($attachment->file_path, [
            'Content-Type' => $attachment->content_type,
            'Content-Disposition' => 'inline; filename="' . $attachment->original_filename . '"'
        ]);
    }
}
