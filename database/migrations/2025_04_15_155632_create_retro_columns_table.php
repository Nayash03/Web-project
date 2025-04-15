<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('retro_columns', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('retrospective_id')->constrained()->onDelete('cascade');
            $table->integer('position')->default(0);
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('retro_columns');
    }
};
