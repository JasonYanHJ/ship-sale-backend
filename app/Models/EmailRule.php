<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EmailRule extends Model
{
    public function conditionGroups(): HasMany
    {
        return $this->hasMany(RuleConditionGroup::class, 'rule_id');
    }

    public function actions(): HasMany
    {
        return $this->hasMany(RuleAction::class, 'rule_id');
    }
}
