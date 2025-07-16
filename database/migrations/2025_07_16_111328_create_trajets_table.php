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
        Schema::disableForeignKeyConstraints();

        Schema::create('trajets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pays_depart_id')->constrained('pays');
            $table->foreignId('pays_arrivee_id')->constrained('pays');
            $table->string('ville_depart');
            $table->string('ville_arrivee');
            $table->date('date_depart');
            $table->date('date_arrivee');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trajets');
    }
};
