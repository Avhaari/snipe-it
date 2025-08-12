<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asset_test_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_test_run_id')->constrained('asset_test_runs')->cascadeOnDelete();
            $table->string('component');
            $table->enum('status', ['pass','fail','na']);
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->index(['asset_test_run_id', 'component']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asset_test_items');
    }
};
