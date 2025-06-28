<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RuleConditionGroup extends Model
{
    public function conditions(): HasMany
    {
        return $this->hasMany(RuleCondition::class, 'group_id');
    }
}
