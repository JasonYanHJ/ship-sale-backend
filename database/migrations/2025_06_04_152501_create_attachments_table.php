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
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();

            // 外键关联到 emails 表
            $table->foreignId('email_id')
                ->constrained('emails')
                ->onDelete('cascade');

            $table->string('original_filename', 255)->nullable();
            $table->string('stored_filename', 255)->nullable();
            $table->string('file_path', 500)->nullable();
            $table->bigInteger('file_size')->nullable();
            $table->string('content_type', 100)->nullable();

            // Content-Disposition类型(如attachment/inline/form-data等)
            $table->string('content_disposition_type', 50)->nullable();

            $table->timestamps();

            // 索引
            $table->index('email_id', 'idx_email_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attachments');
    }
};
