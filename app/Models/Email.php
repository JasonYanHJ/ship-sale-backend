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

    protected $hidden = [
        "raw_headers",
    ];

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }

    public function newQuery()
    {
        // 不获取'raw_headers'字段
        return parent::newQuery()->select([
            'id',
            'subject',
            'message_id',
            'sender',
            'recipients',
            'cc',
            'bcc',
            'content_text',
            'content_html',
            'date_sent',
            'date_received',
            'created_at',
            'updated_at',
        ]);
    }
}
