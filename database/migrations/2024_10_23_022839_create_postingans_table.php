<?php

use App\Models\User;
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
        if (Schema::hasTable('app_postingan')) {
            Schema::dropIfExists('app_postingan');
        }

        Schema::create('app_postingan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->string('judul', 255)->nullable();
            $table->text('konten')->nullable();
            $table->string('slug', 255)->nullable();
            $table->foreignUuid('berkas_id')->nullable()->constrained('app_berkas')->onDelete('cascade');
            $table->boolean('publish')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_postingan');
    }
};
