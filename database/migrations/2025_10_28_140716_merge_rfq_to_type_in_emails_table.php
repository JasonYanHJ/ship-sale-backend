<?php

use App\Models\Email;
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
        Email::select('id', 'rfq')
            ->where('rfq', true)
            ->update(['type' => 'RFQ']);
        Schema::table('emails', function (Blueprint $table) {
            $table->dropColumn('rfq');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('emails', function (Blueprint $table) {
            $table->boolean('rfq')->nullable()->comment('询价邮件标记');
        });
        Email::select('id', 'type')
            ->where('type', 'RFQ')
            ->update(['rfq' => true, 'type' => NULL]);
    }
};
