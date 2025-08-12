<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('asset_test_runs')) {
            return;
        }

        Schema::create('asset_test_runs', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('asset_id');
            $table->unsignedInteger('user_id');
            $table->foreign('asset_id')->references('id')->on('assets')->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->restrictOnDelete();
            $table->string('test_type')->nullable();
            $table->enum('status', ['in_progress', 'completed'])->default('in_progress');
            $table->string('os_version')->nullable();
            $table->text('notes')->nullable();
            $table->dateTime('started_at')->nullable();
            $table->dateTime('finished_at')->nullable();
            $table->timestamps();
            $table->index('asset_id');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asset_test_runs');
    }
};
