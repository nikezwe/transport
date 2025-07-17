<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('annonces', function (Blueprint $table) {
        $table->id();
        $table->enum('direction', ['chine-burundi', 'burundi-chine']);
        $table->date('date_depart');
        $table->date('date_limite')->nullable();
        $table->string('ville_depart');
        $table->string('ville_arrivee');
        $table->text('adresse_collecte');
        $table->text('adresse_livraison');
        $table->decimal('poids', 8, 2);
        $table->string('dimensions')->nullable();
        $table->decimal('valeur', 10, 2)->nullable();
        $table->integer('nombre_colis')->default(1);
        $table->text('description');
        $table->decimal('budget', 10, 2)->nullable();
        $table->enum('urgence', ['normale', 'urgent', 'tres-urgent'])->default('normale');
        $table->text('commentaires')->nullable();
        $table->enum('statut', ['en_attente', 'en_cours', 'livre', 'annule'])->default('en_attente');
        $table->boolean('active')->default(true);
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('annonces');
    }
};
