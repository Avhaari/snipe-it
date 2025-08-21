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
            $table->increments('id');
            $table->unsignedInteger('asset_test_run_id');
            $table->foreign('asset_test_run_id')->references('id')->on('asset_test_runs')->onDelete('cascade');
            $table->string('component');
            $table->enum('status', ['pass','fail','na'])->default('na');
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
