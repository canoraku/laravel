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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->char('title', length:125);
            $table->char('thumbnail', length:125);
            $table->text('content');
            $table->unsignedBigInteger('author')->nullable();
            $table->foreign('author')->references('id')->on('users')->onDelete('set null');
            $table->date('expired');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropForeign(['author']);
        });
        Schema::dropIfExists('posts');
    }
};
