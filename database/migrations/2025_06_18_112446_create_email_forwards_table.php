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
        Schema::create('email_forwards', function (Blueprint $table) {
            $table->id();

            // 外键关联到 emails 表
            $table->foreignId('email_id')
                ->constrained('emails')
                ->onDelete('cascade');

            $table->text('to_addresses');
            $table->text('cc_addresses')->nullable();
            $table->text('bcc_addresses')->nullable();
            $table->text('additional_message')->nullable();
            $table->enum('forward_status', ['pending', 'sent', 'failed'])->default('pending');
            $table->text('error_message')->nullable();
            $table->timestamp('forwarded_at')->useCurrent();
            $table->timestamps();

            // 索引
            $table->index('email_id', 'idx_email_id');
            $table->index('forwarded_at', 'idx_forwarded_at');
            $table->index('forward_status', 'idx_forward_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_forwards');
    }
};
