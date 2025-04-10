<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users_schools', function (Blueprint $table) {
            // Supprimer la clé étrangère et la colonne 'promotion_id'
            $table->dropForeign(['promotion_id']);
            $table->dropColumn('promotion_id');

            // Ajouter la colonne 'cohort_id' qui est une clé étrangère vers 'cohorts'
            $table->unsignedBigInteger('cohort_id')->nullable()->after('school_id');
            $table->foreign('cohort_id')->references('id')->on('cohorts')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('users_schools', function (Blueprint $table) {
            // Revenir en arrière : supprimer 'cohort_id' et recréer 'promotion_id'
            $table->dropForeign(['cohort_id']);
            $table->dropColumn('cohort_id');

            // Ajouter 'promotion_id' (pour le cas où tu voudrais annuler la migration)
            $table->unsignedBigInteger('promotion_id')->nullable()->after('school_id');
            $table->foreign('promotion_id')->references('id')->on('promotions')->onDelete('set null');
        });
    }
};

