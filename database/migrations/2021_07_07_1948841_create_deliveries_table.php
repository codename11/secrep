<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();

            $table->string('load_place');
            $table->string('unload_place');
            $table->string('comment');
            $table->string('time_in');
            $table->string('time_out');

            $table->unsignedBigInteger('vehicle_id')->nullable();
            $table->foreign("vehicle_id")->references("id")->on("vehicles")->onUpdate('cascade')->onDelete('cascade');

            $table->unsignedBigInteger('cistern_id')->nullable();
            $table->foreign("cistern_id")->references("id")->on("cisterns")->onUpdate('cascade')->onDelete('cascade');

            $table->unsignedBigInteger('operator_id')->nullable();
            $table->foreign("operator_id")->references("id")->on("employees")->onUpdate('cascade')->onDelete('cascade');

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
        Schema::dropIfExists('deliveries');
    }
}
