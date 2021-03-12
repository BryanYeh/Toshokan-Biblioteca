<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLendsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lends', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('book_id');
            $table->dateTime('lend_date');
            $table->dateTime('returned_date')->nullable();
            $table->decimal('late_fee_paid', $precision = 8, $scale = 2)->default(0.00);
            $table->decimal('damaged_fee_paid', $precision = 8, $scale = 2)->default(0.00);
            $table->boolean('is_damaged')->default(false);
            $table->text('notes')->nullable();
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
        Schema::dropIfExists('lends');
    }
}
