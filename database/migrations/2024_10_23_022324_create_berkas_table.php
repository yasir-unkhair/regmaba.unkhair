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
        if (Schema::hasTable('app_berkas')) {
            Schema::dropIfExists('app_berkas');
        }

        Schema::create('app_berkas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name_berkas', 225)->nullable();
            $table->string('path_berkas', 225)->nullable();
            $table->string('url_berkas', 225)->nullable();
            $table->string('type_berkas', 25)->nullable();
            $table->string('size_berkas', 15)->nullable();
            $table->enum('penyimpanan', ['local', 'cloud'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_berkas');
    }
};
