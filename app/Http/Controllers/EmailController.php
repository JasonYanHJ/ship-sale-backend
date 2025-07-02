<?php

namespace App\Http\Controllers;

use App\Models\Email;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    public function index(Request $request)
    {
        $query = Email::with('attachments')
            ->with('forwards')
            ->latest('date_sent');

        // 根据发信日期筛选
        if ($request->filled('date_sent')) {
            $query->whereBetween('date_sent', [$request->date_sent . ' 00:00:00', $request->date_sent . ' 23:59:59']);
        }

        // 数据分页
        $emails = $query->paginate($request->pageSize ?? 10, ['*'], 'current');

        return response()->json([
            'data' => $emails,
        ]);
    }
}
