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
        Schema::create('email_rules', function (Blueprint $table) {
            $table->id(); // 等同于 BIGINT PRIMARY KEY AUTO_INCREMENT
            $table->string('name', 100)->comment('规则名称');
            $table->text('description')->nullable()->comment('规则描述');
            $table->enum('global_group_logic', ['AND', 'OR'])->default('AND')->comment('条件组间的全局逻辑');
            $table->integer('priority')->default(0)->comment('优先级，数字越大优先级越高');
            $table->boolean('is_active')->default(true)->comment('是否启用');
            $table->boolean('stop_on_match')->default(false)->comment('匹配后是否停止执行后续规则');
            $table->timestamps(); // 自动创建 created_at 和 updated_at 字段

            // 索引
            $table->index('priority', 'idx_priority');
            $table->index('is_active', 'idx_is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_rules');
    }
};
