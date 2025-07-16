<?php

namespace App\Http\Controllers;

use App\Models\Email;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmailController extends Controller
{
    public function index(Request $request)
    {
        $query = Email::with('attachments.tags')
            ->with('forwards')
            ->latest('date_sent');

        // 根据是否被分配筛选
        if ($request->filled('dispatched')) {
            if ($request->dispatched)
                $query->whereNot('dispatcher_id', null);
            else
                $query->where('dispatcher_id', null);
        }

        $emails = Email::getPaginatedEmailsByRequestParams($request, $query);

        return response()->json([
            'data' => $emails,
        ]);
    }

    public function indexByDispatcher(Request $request)
    {
        $query = Email::with('attachments.tags')
            ->with('forwards')
            ->latest('date_sent');

        $query->where('dispatcher_id', Auth::id());

        $emails = Email::getPaginatedEmailsByRequestParams($request, $query);

        return response()->json([
            'data' => $emails,
        ]);
    }

    public function dispatchEmail(Request $request, Email $email)
    {
        $email->dispatcher_id = $request->dispatcher_id;
        $email->save();

        return response()->json([
            'message' => '分配成功',
        ]);
    }
}
