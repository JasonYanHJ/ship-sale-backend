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
        Schema::create('emails', function (Blueprint $table) {
            $table->id();

            // 邮件唯一标识，用于去重
            $table->string('message_id', 255)->unique()->comment('邮件唯一标识，用于去重');

            $table->text('subject')->nullable();
            $table->string('sender', 255)->nullable();

            // JSON格式存储多个收件人、抄送人、密送人
            $table->text('recipients')->nullable()->comment('JSON格式存储多个收件人');
            $table->text('cc')->nullable()->comment('JSON格式存储抄送人');
            $table->text('bcc')->nullable()->comment('JSON格式存储密送人');

            $table->longText('content_text')->nullable();
            $table->longText('content_html')->nullable();

            $table->dateTime('date_sent')->nullable();
            $table->dateTime('date_received')->useCurrent(); // DEFAULT CURRENT_TIMESTAMP

            // 原始邮件头
            $table->longText('raw_headers')->nullable()->comment('原始邮件头');

            $table->timestamps();

            // 索引
            $table->index('message_id', 'idx_message_id');
            $table->index('date_received', 'idx_date_received');
            $table->index('sender', 'idx_sender');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emails');
    }
};
