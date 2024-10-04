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
        Schema::create('data', function (Blueprint $table) {
            $table->id();
            $table->integer('intensity');
            $table->integer('likelihood');
            $table->integer('relevance');
            $table->integer('year');
            $table->string('country');
            $table->string('topics');
            $table->string('region');
            $table->string('city');
            $table->string('sector');
            $table->string('pestle');
            $table->string('source');
            $table->string('swot');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data');
    }
};
