<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComplementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('complement', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('vehicle_id')->nullable();
            $table->foreign("vehicle_id")->references("id")->on("vehicles")->onUpdate('cascade')->onDelete('cascade');
            
            $table->unsignedBigInteger('delivery_id')->nullable();
            $table->foreign("delivery_id")->references("id")->on("deliveries")->onUpdate('cascade')->onDelete('cascade');

            $table->unsignedBigInteger('sec_id')->nullable();
            $table->foreign("sec_id")->references("id")->on("users")->onUpdate('cascade')->onDelete('cascade');
            
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
        Schema::dropIfExists('complement');
    }
}
