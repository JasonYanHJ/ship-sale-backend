<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function allDispatchers()
    {
        $dispatchers = User::withRole('dispatcher')->get();
        return response()->json([
            'data' => $dispatchers,
        ]);
    }
}
