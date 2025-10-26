<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Saler extends Model
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'description',
        'leader_id',
        'abbr',
    ];

    /**
     * 获取与销售员关联的标签
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * 同步标签与销售员的关联
     *
     * @param array $tagNames
     * @return $this
     */
    public function syncTags(array $tagNames)
    {
        $tagIds = [];

        foreach ($tagNames as $tagName) {
            // 查找或创建标签
            $tag = Tag::firstOrCreate(['name' => $tagName]);
            $tagIds[] = $tag->id;
        }

        // 同步标签关系
        $this->tags()->sync($tagIds);

        return $this;
    }

    public function leader()
    {
        return $this->belongsTo(Saler::class, 'leader_id');
    }
}
