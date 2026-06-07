<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    public function up(): void
    {
        Schema::create('etudiants', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->primary();
            $table->foreignId('ville_id')->constrained('villes');
            $table->foreignId('etablissement_id')->constrained('etablissements');
            $table->foreignId('filiere_id')->constrained('filieres');
            $table->enum('niveau_etudes', ['Bac+2', 'Bac+3', 'Bac+5', 'Doctorat']);
            $table->string('photo')->nullable();
            $table->text('bio')->nullable();
            $table->string('github')->nullable();
            $table->string('linkedin')->nullable();
            $table->unsignedInteger('vues')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('etudiants');
    }
};
