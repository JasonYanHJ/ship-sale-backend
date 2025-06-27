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
        Schema::create('rule_condition_groups', function (Blueprint $table) {
            $table->id();

            // 外键约束
            $table->foreignId('rule_id')
                ->constrained('email_rules')
                ->onDelete('cascade');

            $table->string('group_name', 100)->nullable()->comment('条件组语义名称');
            $table->enum('group_logic', ['AND', 'OR'])->default('AND')->comment('组内条件逻辑关系');
            $table->integer('group_order')->default(0)->comment('条件组执行顺序');
            $table->timestamps();

            // 索引
            $table->index('rule_id', 'idx_rule_id');
            $table->index('group_order', 'idx_group_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rule_condition_groups');
    }
};
