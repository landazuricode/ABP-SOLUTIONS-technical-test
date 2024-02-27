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
        Schema::table('Saved_cities', function (Blueprint $table) {
            $table->string('name');
            $table->float('latitude');
            $table->float('longitude');
            $table->string('country');
            $table->unsignedBigInteger('population');
            $table->boolean('is_capital');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('Saved_cities', function (Blueprint $table) {
            //
        });
    }
};
