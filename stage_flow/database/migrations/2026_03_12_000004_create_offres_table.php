<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('offres', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->text('description');
            $table->enum('type_stage', ['PFE', 'Technique', 'Observation']);
            $table->string('duree');
            $table->enum('remuneration', ['Payé', 'Non-payé']);
            $table->enum('format', ['Hybride', 'Télétravail', 'Présentiel']);
            $table->enum('secteur', ['Informatique', 'Design', 'Marketing', 'Commerce', 'Industrie', 'Autre']);
            $table->foreignId('ville_id')->constrained('villes');
            $table->text('responsabilites');
            $table->text('profil_recherche');
            $table->json('competences_techniques')->nullable();
            $table->enum('status', ['Active', 'Expirée'])->default('Active');
            $table->timestamp('date_publication')->useCurrent();
            $table->date('date_debut');
            $table->date('date_fin');
            $table->foreignId('entreprise_id')->constrained('entreprises', 'user_id');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('offres');
    }
};
