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
        Schema::create('registrants', function (Blueprint $table) {
            $table->id();
            $table->char('name', length:125);
            $table->integer('NIM');
            $table->char('number_hp', length:125);
            $table->date('birth_date');
            $table->unsignedBigInteger('prodi_id')->nullable();
            $table->foreign('prodi_id')->references('id')->on('prodis')->onDelete('set null');
            $table->char('motivation_later', length:225);
            $table->char('CV', length:225);
            $table->integer('is_accepted');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registrants', function (Blueprint $table) {
            $table->dropForeign(['prodi_id']);
        });
        Schema::dropIfExists('registrants');
    }
};
