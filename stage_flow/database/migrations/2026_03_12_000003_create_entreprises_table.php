<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('entreprises', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->primary();
            $table->string('nom_entreprise');
            $table->foreignId('secteur_id')->constrained('secteurs');
            $table->foreignId('ville_id')->constrained('villes');
            $table->string('adresse');
            $table->string('email_contact');
            $table->text('bio')->nullable();
            $table->string('registre_commerce');
            $table->string('logo')->nullable();
            $table->enum('taille', ['TPE / PME', 'Grande Entreprise', 'Multinationale']);
            $table->unsignedInteger('vues')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('entreprises');
    }
};
