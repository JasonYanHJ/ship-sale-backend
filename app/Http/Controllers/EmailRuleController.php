<?php

namespace App\Http\Controllers;

use App\Models\EmailRule;
use Illuminate\Http\Request;

class EmailRuleController extends Controller
{
    public function index()
    {
        $emailRules = EmailRule::with('actions')
            ->with('conditionGroups.conditions')
            ->get();

        return response()->json([
            'data' => $emailRules,
        ]);
    }
}
