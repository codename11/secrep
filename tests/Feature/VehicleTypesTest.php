<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Laravel\Passport\Passport;
use App\User;
use App\Vehicle;
  
//https://www.bacancytechnology.com/blog/feature-testing-in-laravel
//https://laravel.com/docs/9.x/testing#main-content
//https://laravel-news.com/how-to-start-testing
//https://www.youtube.com/watch?v=J0OFwSk9iV8&ab_channel=Laraveller
//DELETE FROM `users` WHERE id NOT BETWEEN 1 AND 2
//DELETE FROM `vehicles` WHERE id NOT BETWEEN 1 AND 15
//DELETE FROM `work_organizations` WHERE id NOT BETWEEN 1 AND 3
//DELETE FROM `special_permissions` WHERE id NOT BETWEEN 1 AND 3
//$user1 = User::where("id", "=", 1)->get();
//$user2 = ["id" => 1, "name" => "veljko", "email" => "veljkos82@gmail.com", "role_id" => 1, "email_verified_at" => null, "password" => '$2y$10$BWieAhdzRxUX4ndW.6Ki4u8eix5AtYhOJl6dB4YbVAAZr8xg/IXTa', "remember_token" => null, "created_at" => "2012-07-17 17:18:59", "updated_at" => "2022-12-07 17:20:58", "special_permission_id" => 1, "deleted_at" => null];
/*
php artisan cache:clear
php artisan route:clear
php artisan config:clear
php artisan view:clear
*/
//php artisan test
//Target specific test: php artisan test --filter *nameoftest*
//php artisan make:test *nameoftest*
//Need to be on lookout for soft deleted stuff...

class VehicleTypesTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create_vehicle_type()
    {
        $request = [
            "name" => "Semi",
        ];

        $user = User::first();
        Passport::actingAs(
            $user,
            ["http://secrep.test/api/create_vehicle_pivot"]
        );
        
        $req = $this->post("http://secrep.test/api/create_vehicle_pivot", $request, ["X-Requested-With" => "XMLHttpRequest"]);
        
        $response = $req->assertJsonStructure(["message"]);// A "message"(just string) is my personal way of aknowledging if correct results are returned.
     
        $response->assertStatus(200);

    }

    public function test_list_vehicle_pivot()
    {
        //Simulation of data entered by user.
        $request = [];

        //Simulation of passing on token.
        $user = User::first();
        Passport::actingAs(
            $user,
            ["http://secrep.test/api/list_vehicle_pivot"]
        );

        //Simulation of post method via ajax request and checking if returned result have proper json structure.
        $response = $this->get("http://secrep.test/api/list_vehicle_pivot", $request, ["X-Requested-With" => "XMLHttpRequest"]/*Test if request is ajax*/)
        ->assertJsonStructure([
            "message"
        ]);// A "message"(just string) is my personal way of aknowledging if correct results are returned.
     
        $response->assertStatus(200);

    }

    public function test_show_vehicle_pivot()
    {
        $request = [
            "id" => 1
        ];
        
        $user = User::first();
        Passport::actingAs(
            $user,
            ["http://secrep.test/api/show_vehicle_pivot"]
        );

        $response = $this->get("http://secrep.test/api/show_vehicle_pivot", $request, ["X-Requested-With" => "XMLHttpRequest"])
        ->assertJsonStructure([
            "message"
        ]);// A "message"(just string) is my personal way of aknowledging if correct results are returned.
     
        $response->assertStatus(200);

    }

    public function test_update_vehicle_pivot()
    {
        $request = [
            "id" => 1,
            "name" => "truck"
        ];

        $user = User::first();
        Passport::actingAs(
            $user,
            ["http://secrep.test/api/update_vehicle_pivot"]
        );

        $response = $this->patch("http://secrep.test/api/update_vehicle_pivot", $request, ["X-Requested-With" => "XMLHttpRequest"])
        ->assertJsonStructure([
            "message"
        ]);// A "message"(just string) is my personal way of aknowledging if correct results are returned.
     
        $response->assertStatus(200);

    }

    public function test_delete_vehicle_pivot()
    {
        $request = [
            "id" => 1
        ];

        $user = User::first();
        Passport::actingAs(
            $user,
            ["http://secrep.test/api/delete_vehicle_pivot"]
        );

        $response = $this->delete("http://secrep.test/api/delete_vehicle_pivot", $request, ["X-Requested-With" => "XMLHttpRequest"])
        ->assertJsonStructure([
            "message"
        ]);// A "message"(just string) is my personal way of aknowledging if correct results are returned.
     
        $response->assertStatus(200);

    }

}
