<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Email extends Model
{
    static public function getPaginatedEmailsByRequestParams(Request $request, Builder $query)
    {
        // 根据主题筛选
        if ($request->filled('subject')) {
            $query->where('subject', 'like', '%' . $request->subject . '%');
        }

        // 根据发件人筛选
        if ($request->filled('sender')) {
            $query->where('sender', 'like', '%' . $request->sender . '%');
        }

        // 根据发信日期筛选
        if ($request->filled('date_sent')) {
            $query->whereBetween('date_sent', [$request->date_sent . ' 00:00:00', $request->date_sent . ' 23:59:59']);
        }

        // 根据询价标记筛选
        if ($request->has('rfq')) {
            $query->where('rfq', $request->rfq);
        }

        // 根据具体询价类型标记筛选
        if ($request->has('rfq_type')) {
            $query->where('rfq_type', $request->rfq_type);
        }

        // 数据分页
        return $query->paginate($request->pageSize ?? 10, ['*'], 'current');
    }

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

    public function forwards()
    {
        return $this->hasMany(EmailForward::class)->latest('forwarded_at');
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
            'rfq',
            'rfq_type',
            'dispatcher_id',
        ]);
    }
}
