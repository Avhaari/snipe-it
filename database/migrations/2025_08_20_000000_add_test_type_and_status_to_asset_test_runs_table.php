<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('asset_test_runs', function (Blueprint $table) {
            if (!Schema::hasColumn('asset_test_runs', 'test_type')) {
                $table->string('test_type')->nullable()->after('user_id');
            }

            if (!Schema::hasColumn('asset_test_runs', 'status')) {
                $table->enum('status', ['in_progress', 'completed'])->default('in_progress')->after('test_type');
            }
        });
    }

    public function down(): void
    {
        Schema::table('asset_test_runs', function (Blueprint $table) {
            if (Schema::hasColumn('asset_test_runs', 'status')) {
                $table->dropColumn('status');
            }

            if (Schema::hasColumn('asset_test_runs', 'test_type')) {
                $table->dropColumn('test_type');
            }
        });
    }
};
