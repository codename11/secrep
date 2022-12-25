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
            "id" => 11
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
