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
        Schema::create('rule_actions', function (Blueprint $table) {
            $table->id();

            // 外键约束
            $table->foreignId('rule_id')
                ->constrained('email_rules')
                ->onDelete('cascade');

            $table->enum('action_type', ['skip', 'set_field']);
            $table->json('action_config')->nullable()->comment('动作配置参数');
            $table->integer('action_order')->default(0)->comment('动作执行顺序');
            $table->timestamps();

            // 索引
            $table->index('rule_id', 'idx_rule_id');
            $table->index('action_order', 'idx_action_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rule_actions');
    }
};
