<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();

            $table->string('lastName');
            $table->string('firstName');

            $table->unsignedBigInteger('work_org_id')->nullable();
            $table->foreign("work_org_id")->references("id")->on("work_organizations")->onUpdate('cascade')->onDelete('cascade');

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
        Schema::dropIfExists('employees');
    }
}
