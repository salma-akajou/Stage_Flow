<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('document_cvs', function (Blueprint $table) {
            $table->id();
            $table->string('file_path');
            $table->timestamp('date_upload')->useCurrent();
            $table->foreignId('etudiant_id')->constrained('etudiants', 'user_id')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('document_cvs');
    }
};
