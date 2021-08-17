<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_locations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id');
            $table->foreignId('location_id');
            $table->string('barcode')->unique();
            $table->string('call_number')->comment('Which shelf in the library?');
            $table->string('section')->comment('What section of the library?');
            $table->decimal('price', $precision = 8, $scale = 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('book_locations');
    }
}
