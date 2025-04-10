<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::create('competences', function (Blueprint $table) {
        $table->id();
        $table->string('nom');
        $table->foreignId('cohort_id')->constrained()->onDelete('cascade'); // si tu as des cohortes
        $table->timestamps();
    });
}

};
