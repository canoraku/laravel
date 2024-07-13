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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->char('title', length:125);
            $table->char('thumbnail', length:225);
            $table->text('description');
            $table->date('date');
            $table->integer('status');
            $table->unsignedBigInteger('author')->nullable();
            $table->foreign('author')->references('id')->on('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropForeign(['author']);
        });
        Schema::dropIfExists('events');
    }
};
