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
        Schema::table('users', function (Blueprint $table) {
            // Menambahkan kolom roles_id
            $table->unsignedBigInteger('roles_id')->nullable();

            // Menambahkan foreign key constraint jika diperlukan
            $table->foreign('roles_id')->references('id')->on('roles')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
             // Menghapus foreign key constraint terlebih dahulu jika ada
            $table->dropForeign(['roles_id']);
            
            // Menghapus kolom roles_id
            $table->dropColumn('roles_id');
        });
    }
};
