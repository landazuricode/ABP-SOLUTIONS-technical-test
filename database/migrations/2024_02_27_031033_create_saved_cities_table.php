<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('saved_cities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('city_name');
            $table->decimal('latitude', 8, 6);
            $table->decimal('longitude', 9, 6);
            $table->char('country', 2);
            $table->integer('population');
            $table->boolean('is_capital');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('saved_cities');
    }
};
