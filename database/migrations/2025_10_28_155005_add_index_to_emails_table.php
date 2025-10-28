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
        Schema::table('emails', function (Blueprint $table) {
            $table->index('type', 'idx_type');
            $table->index('from', 'idx_from');
            $table->index('date_sent', 'idx_date_sent');
            $table->dropIndex('idx_date_received');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('emails', function (Blueprint $table) {
            $table->dropIndex('idx_type');
            $table->dropIndex('idx_from');
            $table->dropIndex('idx_date_sent');
        });
    }
};
