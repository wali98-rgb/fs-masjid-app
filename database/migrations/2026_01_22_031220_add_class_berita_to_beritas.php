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
        Schema::table('beritas', function (Blueprint $table) {
            $table->enum('class_berita', ['-', 'harian', 'bulanan', 'tahunan'])->default('-')->after('is_active');
            $table->date('tanggal_awal')->nullable()->after('class_berita');
            $table->date('tanggal_akhir')->nullable()->after('tanggal_awal');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->after('tanggal_akhir');
            $table->text('thumbnail')->nullable()->after('cover');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('beritas', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn(['class_berita', 'tanggal_awal', 'tanggal_akhir', 'user_id', 'thumbnail']);
        });
    }
};
