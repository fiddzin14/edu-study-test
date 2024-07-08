<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('brand', 50);
            $table->text('model')->nullable();
            $table->string('screen_size', 256)->nullable();
            $table->string('color', 256)->nullable();
            $table->string('harddisk', 50)->nullable();
            $table->string('cpu', 124)->nullable();
            $table->string('ram', 50)->nullable();
            $table->string('OS', 256)->nullable();
            $table->string('special_features', 256)->nullable();
            $table->string('graphics', 256)->nullable();
            $table->string('graphics_coprocessor', 256)->nullable();
            $table->string('cpu_speed', 50)->nullable();
            $table->string('rating', 50)->nullable();
            $table->string('price', 50)->nullable();
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
        Schema::dropIfExists('product');
    }
}
