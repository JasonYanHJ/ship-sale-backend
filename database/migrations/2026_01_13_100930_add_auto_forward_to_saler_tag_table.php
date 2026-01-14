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
        Schema::table('saler_tag', function (Blueprint $table) {
            $table->boolean('auto_forward')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('saler_tag', function (Blueprint $table) {
            $table->dropColumn('auto_forward');
        });
    }
};
