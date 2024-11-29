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
        if (Schema::hasTable('app_referensi')) {
            Schema::dropIfExists('app_referensi');
        }

        Schema::create('app_referensi', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('parent_id')->nullable()->references('id')->on('app_referensi')->comment('parent referensi');
            $table->text('referensi')->nullable();
            $table->enum('aktif', ['Y', 'N'])->default('Y')->comment('status referensi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_referensi');
    }
};
