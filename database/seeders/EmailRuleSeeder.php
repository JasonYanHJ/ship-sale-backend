<?php

namespace Database\Seeders;

use App\Models\EmailRule;
use App\Models\RuleAction;
use App\Models\RuleCondition;
use App\Models\RuleConditionGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmailRuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // =============================================================================

        $rule1 = EmailRule::create([
            "name" => "过滤非询价邮件",
            "description" => "为了避免把可能的询价邮件过滤掉，此规则只将“一定”不是询价的邮件过滤掉，仍可能会保留一些其他邮件。",
            "global_group_logic" => "OR",
            "priority" => 10,
            "is_active" => 1,
            "stop_on_match" => 1,
        ]);

        RuleAction::create([
            "rule_id" => $rule1->id,
            "action_type" => "skip",
        ]);

        $rule1ConditionGroup1 = RuleConditionGroup::create([
            "rule_id" => $rule1->id,
            "group_name" => "由自己发出的邮件",
            "group_logic" => "OR",
            "group_order" => 0,
        ]);
        RuleCondition::create([
            "group_id" => $rule1ConditionGroup1->id,
            "field_type" => "sender",
            "operator" => "contains",
            "match_value" => "@dan-marine",
            "case_sensitive" => 0,
            "condition_order" => 0,
        ]);

        $rule1ConditionGroup2 = RuleConditionGroup::create([
            "rule_id" => $rule1->id,
            "group_name" => "回复类邮件",
            "group_logic" => "OR",
            "group_order" => 1,
        ]);
        RuleCondition::create([
            "group_id" => $rule1ConditionGroup2->id,
            "field_type" => "subject",
            "operator" => "regex",
            "match_value" => "^(回复|答复|回覆|答覆)",
            "case_sensitive" => 0,
            "condition_order" => 0,
        ]);
        RuleCondition::create([
            "group_id" => $rule1ConditionGroup2->id,
            "field_type" => "subject",
            "operator" => "regex",
            "match_value" => "^re\\s*[:：]",
            "case_sensitive" => 0,
            "condition_order" => 1,
        ]);


        $rule1ConditionGroup3 = RuleConditionGroup::create([
            "rule_id" => $rule1->id,
            "group_name" => "转发类邮件",
            "group_logic" => "OR",
            "group_order" => 2,
        ]);
        RuleCondition::create([
            "group_id" => $rule1ConditionGroup3->id,
            "field_type" => "subject",
            "operator" => "starts_with",
            "match_value" => "转发",
            "case_sensitive" => 0,
            "condition_order" => 0,
        ]);
        RuleCondition::create([
            "group_id" => $rule1ConditionGroup3->id,
            "field_type" => "subject",
            "operator" => "regex",
            "match_value" => "^fw\\s*[:：]",
            "case_sensitive" => 0,
            "condition_order" => 1,
        ]);

        $rule1ConditionGroup4 = RuleConditionGroup::create([
            "rule_id" => $rule1->id,
            "group_name" => "系统通知",
            "group_logic" => "OR",
            "group_order" => 3,
        ]);
        RuleCondition::create([
            "group_id" => $rule1ConditionGroup4->id,
            "field_type" => "sender",
            "operator" => "contains",
            "match_value" => "@qiye.163",
            "case_sensitive" => 0,
            "condition_order" => 0,
        ]);

        // =============================================================================

        $rule2 = EmailRule::create([
            "name" => "标记来自ShipServ询价邮件",
            "description" => "标记来自ShipServ询价邮件",
            "global_group_logic" => "AND",
            "priority" => 9,
            "is_active" => 1,
            "stop_on_match" => 0,
        ]);

        RuleAction::create([
            "rule_id" => $rule2->id,
            "action_type" => "set_field",
            "action_config" => [
                "field_name" => "rfq",
                "field_value" => 1
            ],
            "action_order" => 0,
        ]);
        RuleAction::create([
            "rule_id" => $rule2->id,
            "action_type" => "set_field",
            "action_config" => [
                "field_name" => "rfq_type",
                "field_value" => "ShipServ"
            ],
            "action_order" => 1,
        ]);

        $rule2ConditionGroup1 = RuleConditionGroup::create([
            "rule_id" => $rule2->id,
            "group_name" => "ShipServ",
            "group_logic" => "AND",
            "group_order" => 0,
        ]);
        RuleCondition::create([
            "group_id" => $rule2ConditionGroup1->id,
            "field_type" => "sender",
            "operator" => "equals",
            "match_value" => "info@shipserv.com",
            "case_sensitive" => 0,
            "condition_order" => 0,
        ]);
        RuleCondition::create([
            "group_id" => $rule2ConditionGroup1->id,
            "field_type" => "subject",
            "operator" => "contains",
            "match_value" => "RFQ",
            "case_sensitive" => 1,
            "condition_order" => 1,
        ]);

        // =============================================================================

        $rule3 = EmailRule::create([
            "name" => "标记其他可能的询价邮件",
            "description" => "通过一些特征匹配来标记出未被具体规则标记来源的其他可能的询价邮件",
            "global_group_logic" => "AND",
            "priority" => 3,
            "is_active" => 1,
            "stop_on_match" => 0,
        ]);

        RuleAction::create([
            "rule_id" => $rule3->id,
            "action_type" => "set_field",
            "action_config" => [
                "field_name" => "rfq",
                "field_value" => 1
            ],
        ]);

        $rule3ConditionGroup1 = RuleConditionGroup::create([
            "rule_id" => $rule3->id,
            "group_name" => "询价邮件可能的特征",
            "group_logic" => "OR",
            "group_order" => 0,
        ]);
        RuleCondition::create([
            "group_id" => $rule3ConditionGroup1->id,
            "field_type" => "subject",
            "operator" => "contains",
            "match_value" => "rfq",
            "case_sensitive" => 0,
            "condition_order" => 0,
        ]);
        RuleCondition::create([
            "group_id" => $rule3ConditionGroup1->id,
            "field_type" => "subject",
            "operator" => "contains",
            "match_value" => "request for quote",
            "case_sensitive" => 1,
            "condition_order" => 1,
        ]);
    }
}
