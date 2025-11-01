<?php

use App\Models\EmailForward;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('email_forwards', function (Blueprint $table) {
            // corrected: 手动更正转发对象而产生的记录，没有实际转发
            DB::statement("ALTER TABLE email_forwards MODIFY COLUMN forward_status ENUM('pending', 'sent', 'failed', 'corrected') NOT NULL DEFAULT 'pending'");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('email_forwards', function (Blueprint $table) {
            // 回滚操作：如果有使用了新的枚举值的转发记录，必须先删除它们，再进行回滚，否则会出错
            EmailForward::where(['forward_status' => 'corrected'])->delete();
            DB::statement("ALTER TABLE email_forwards MODIFY COLUMN forward_status ENUM('pending', 'sent', 'failed') NOT NULL DEFAULT 'pending'");
        });
    }
};
