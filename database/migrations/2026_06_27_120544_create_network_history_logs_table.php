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
        Schema::create('network_history_logs', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_throttled')->default(false);
            $table->unsignedSmallInteger('download_limit')->default(25);
            $table->string('selected_profile')->default('Standard');
            $table->string('source')->nullable()->comment('Originating interface, user, or automation source');
            $table->string('applied_by')->nullable()->comment('User or process that applied the settings');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('network_history_logs');
    }
};
