<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWorkOrganizationIdToVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->unsignedBigInteger('workOrganization_id')->nullable();
            $table->foreign("workOrganization_id")->references("id")->on("work_organizations")->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->unsignedBigInteger('workOrganization_id')->nullable();
            $table->foreign("workOrganization_id")->references("id")->on("work_organizations")->onUpdate('cascade')->onDelete('cascade');
        });
    }
}
