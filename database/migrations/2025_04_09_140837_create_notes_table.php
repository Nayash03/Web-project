<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::create('notes', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // élève
        $table->foreignId('competence_id')->constrained()->onDelete('cascade');
        $table->float('note'); // tu peux mettre `decimal('note', 5, 2)` si tu veux plus de précision
        $table->timestamps();
    });
}

};
