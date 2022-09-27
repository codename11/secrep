<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSoftDeleteToAllMigrations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tables = ["complement", "deliveries", "delivery_details", "employees", "roles", "special_permissions", "users", "utilities", "vehicles", "vehicle_pivot", "work_organizations"];
        
        for($i=0;$i<count($tables);$i++){
            Schema::table($tables[$i], function (Blueprint $table) {
                $table->softDeletes();
            });
        }
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        $tables = ["complement", "deliveries", "delivery_details", "employees", "roles", "special_permissions", "users", "utilities", "vehicles", "vehicle_pivot", "work_organizations"];
        
        for($i=0;$i<count($tables);$i++){
            Schema::table($tables[$i], function (Blueprint $table) {
                $table->dropSoftDeletes();
            });
        }

    }

}
