<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('candidatures', function (Blueprint $table) {
            $table->id();
            $table->enum('statut', ['En attente', 'Accepté', 'Refusé'])->default('En attente');
            $table->string('telephone');
            $table->text('message_motivation');
            $table->timestamp('date_postulation')->useCurrent();
            $table->foreignId('etudiant_id')->constrained('etudiants', 'user_id')->onDelete('cascade');
            $table->foreignId('offre_id')->constrained('offres')->onDelete('cascade');
            $table->foreignId('cv_id')->constrained('document_cvs')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('candidatures');
    }
};
