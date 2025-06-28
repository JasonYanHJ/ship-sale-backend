<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RuleAction extends Model
{
    protected $casts = [
        'action_config' => 'json'
    ];
}
