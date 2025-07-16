<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

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
}
