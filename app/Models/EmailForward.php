<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailForward extends Model
{
    protected $casts = [
        'to_addresses' => 'array',
        'cc_addresses' => 'array',
        'bcc_addresses' => 'array',
        'forward_status' => 'string',
    ];
}
