<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rule_conditions', function (Blueprint $table) {
            $table->id();

            // 外键约束
            $table->foreignId('group_id')
                ->constrained('rule_condition_groups')
                ->onDelete('cascade');

            $table->enum('field_type', ['sender', 'subject', 'body', 'header', 'attachment'])
                ->comment('检查字段类型');
            $table->enum('operator', [
                'contains',
                'not_contains',
                'equals',
                'not_equals',
                'regex',
                'not_regex',
                'starts_with',
                'ends_with'
            ]);
            $table->text('match_value')->comment('匹配值');
            $table->boolean('case_sensitive')->default(false)->comment('是否区分大小写');
            $table->integer('condition_order')->default(0)->comment('条件执行顺序');
            $table->timestamps();

            // 索引
            $table->index('group_id', 'idx_group_id');
            $table->index('condition_order', 'idx_condition_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rule_conditions');
    }
};
