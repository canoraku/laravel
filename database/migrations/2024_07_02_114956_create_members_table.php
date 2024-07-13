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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->char('NIM', length: 25);
            $table->char('name', length: 125);
            $table->char('number_hp', length: 125);
            $table->char('period', length: 40);
            $table->date('birth_date');
            $table->unsignedBigInteger('division_id')->nullable();
            $table->unsignedBigInteger('prodi_id')->nullable();
            $table->foreign('division_id')->references('id')->on('divisions')->onDelete('set null');
            $table->foreign('prodi_id')->references('id')->on('prodis')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropForeign(['division_id']);
            $table->dropForeign(['prodi_id']);
        });
        Schema::dropIfExists('members');
    }
};
