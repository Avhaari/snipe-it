<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('asset_tests', function (Blueprint $table) {
            $table->id();

            // Foreign keys: keep types compatible with Snipe-IT core
            $table->unsignedBigInteger('asset_id');
            $table->foreign('asset_id')->references('id')->on('assets')->onDelete('cascade');

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');

            // Test data
            $table->string('component');                 // e.g. keyboard, hdmi, wifi
            $table->enum('result', ['pass','fail','n_a']);
            $table->text('comment')->nullable();
            $table->timestamp('tested_at')->useCurrent();

            $table->timestamps();

            // Helpful index
            $table->index(['asset_id','tested_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asset_tests');
    }
};
