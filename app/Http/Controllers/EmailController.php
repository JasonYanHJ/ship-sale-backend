<?php

namespace App\Http\Controllers;

use App\Models\Email;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    public function index()
    {
        $emails = Email::with('attachments')->latest('date_sent')->get();

        return response()->json([
            'data' => $emails,
        ]);
    }
}
