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

class SpecPermTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_create_special_permissions()
    {
        $request = [
            "sec_id" => 1,
            "permission_name" => "permissionZZZ",
            "permission_description" => "permisijaZZZ"
        ];

        $user = User::first();
        Passport::actingAs(
            $user,
            ["http://secrep.test/api/create_special_permissions"]
        );

        $response = $this->post("http://secrep.test/api/create_special_permissions", $request, ["X-Requested-With" => "XMLHttpRequest"])
        ->assertJsonStructure([
            "message"
        ]);// A "message"(just string) is my personal way of aknowledging if correct results are returned.
     
        $response->assertStatus(200);

    }

    public function test_list_special_permission()
    {
        //Simulation of data entered by user.
        $request = [];

        //Simulation of passing on token.
        $user = User::first();
        Passport::actingAs(
            $user,
            ["http://secrep.test/api/list_special_permissions"]
        );

        //Simulation of post method via ajax request and checking if returned result have proper json structure.
        $response = $this->get("http://secrep.test/api/list_special_permissions", $request, ["X-Requested-With" => "XMLHttpRequest"]/*Test if request is ajax*/)
        ->assertJsonStructure([
            "message"
        ]);// A "message"(just string) is my personal way of aknowledging if correct results are returned.
     
        $response->assertStatus(200);

    }

    public function test_show_special_permission()
    {
        $request = [
            "id" => 1
        ];
        
        $user = User::first();
        Passport::actingAs(
            $user,
            ["http://secrep.test/api/show_special_permissions"]
        );

        $response = $this->get("http://secrep.test/api/show_special_permissions", $request, ["X-Requested-With" => "XMLHttpRequest"])
        ->assertJsonStructure([
            "message"
        ]);// A "message"(just string) is my personal way of aknowledging if correct results are returned.
     
        $response->assertStatus(200);

    }

    public function test_update_special_permission()
    {
        $request = [
            "id" => 1,
            "permission_name" => "abc",
            "permission_description" => "abc",
            "sec_id" => 1
        ];

        $user = User::first();
        Passport::actingAs(
            $user,
            ["http://secrep.test/api/update_special_permissions"]
        );

        $response = $this->patch("http://secrep.test/api/update_special_permissions", $request, ["X-Requested-With" => "XMLHttpRequest"])
        ->assertJsonStructure([
            "message"
        ]);// A "message"(just string) is my personal way of aknowledging if correct results are returned.
     
        $response->assertStatus(200);

    }

    public function test_delete_special_permission()
    {
        $request = [
            "id" => 1
        ];

        $user = User::first();
        Passport::actingAs(
            $user,
            ["http://secrep.test/api/delete_special_permissions"]
        );

        $response = $this->delete("http://secrep.test/api/delete_special_permissions", $request, ["X-Requested-With" => "XMLHttpRequest"])
        ->assertJsonStructure([
            "message"
        ]);// A "message"(just string) is my personal way of aknowledging if correct results are returned.
     
        $response->assertStatus(200);

    }

}