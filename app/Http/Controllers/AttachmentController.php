<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AttachmentController extends Controller
{
    public function show(Attachment $attachment)
    {
        return Response::file($attachment->file_path, [
            'Content-Type' => $attachment->content_type,
            'Content-Disposition' => 'inline; filename="' . $attachment->original_filename . '"'
        ]);
    }

    public function showByCid(string $cid)
    {
        $attachment = Attachment::where('content_id', $cid)->first();
        if (!$attachment) return new NotFoundHttpException;

        return Response::file($attachment->file_path, [
            'Content-Type' => $attachment->content_type,
            'Content-Disposition' => 'inline; filename="' . $attachment->original_filename . '"'
        ]);
    }

    public function syncTags(Request $request, Attachment $attachment)
    {
        $validated = $request->validate([
            'tag_names' => 'array',
            'tag_names.*' => 'string|max:255',
        ]);

        $attachment->syncTags($validated['tag_names']);

        return response()->json([
            'message' => '标签设置成功',
            'data' => $attachment,
        ]);
    }
}
