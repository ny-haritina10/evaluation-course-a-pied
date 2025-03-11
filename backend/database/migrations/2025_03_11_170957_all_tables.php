<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('password_admin');
            $table->timestamps();
        });

        Schema::create('genre', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->timestamps();
        });

        Schema::create('equipes', function (Blueprint $table) {
            $table->id();
            $table->string('name_equipe');
            $table->string('email')->unique();
            $table->string('password_equipe');
            $table->timestamps();
        });

        Schema::create('coureurs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_genre')->constrained('genre')->onDelete('cascade');
            $table->foreignId('id_equipe')->constrained('equipes')->onDelete('cascade');
            $table->string('name_coureur');
            $table->string('numero_dossard')->unique();
            $table->date('date_naissance');
            $table->timestamps();
        });

        Schema::create('categorie', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->timestamps();
        });

        Schema::create('coureur_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_coureur')->constrained('coureurs')->onDelete('cascade');
            $table->foreignId('id_categorie')->constrained('categorie')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->timestamps();
        });

        Schema::create('etapes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_course')->constrained('courses')->onDelete('cascade');
            $table->string('label');
            $table->decimal('longueur_km', 10, 2);
            $table->integer('nbr_coureur');
            $table->date('date_etape');
            $table->time('heure_depart');
            $table->timestamps();
        });

        Schema::create('etape_coureurs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_etape')->constrained('etapes')->onDelete('cascade');
            $table->foreignId('id_coureur')->constrained('coureurs')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('etape_rang_points', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_etape')->constrained('etapes')->onDelete('cascade');
            $table->integer('rang');
            $table->decimal('point_attribue', 10, 2);
            $table->timestamps();
        });

        Schema::create('etape_coureur_temps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_etape_coureur')->constrained('etape_coureurs')->onDelete('cascade');
            $table->time('temps_depart');
            $table->time('temps_arrivee');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('etape_coureur_temps');
        Schema::dropIfExists('etape_rang_points');
        Schema::dropIfExists('etape_coureurs');
        Schema::dropIfExists('etapes');
        Schema::dropIfExists('courses');
        Schema::dropIfExists('coureur_categories');
        Schema::dropIfExists('categorie');
        Schema::dropIfExists('coureurs');
        Schema::dropIfExists('equipes');
        Schema::dropIfExists('genre');
        Schema::dropIfExists('admins');
    }
};
