<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    protected $casts = [
        'recipients' => 'array',
        'cc' => 'array',
        'bcc' => 'array',
    ];

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }
}
