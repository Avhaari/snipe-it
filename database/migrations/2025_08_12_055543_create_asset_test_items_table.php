<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('asset_test_items')) {
            Schema::table('asset_test_items', function (Blueprint $table) {
                if (!Schema::hasColumn('asset_test_items', 'completed_at')) {
                    $table->timestamp('completed_at')->nullable()->after('notes');
                }
            });

            return;
        }

        Schema::create('asset_test_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_test_run_id')->constrained('asset_test_runs')->cascadeOnDelete();
            $table->string('component');
            $table->enum('status', ['pass','fail','na']);
            $table->text('notes')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            $table->index(['asset_test_run_id', 'component']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asset_test_items');
    }
};
