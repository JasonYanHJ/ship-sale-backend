<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
    ];

    /**
     * 获取与标签关联的销售员
     */
    public function salers()
    {
        return $this->belongsToMany(Saler::class);
    }
}
