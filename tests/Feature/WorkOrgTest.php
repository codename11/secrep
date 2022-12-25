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

class WorkOrgTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_create_work_organizations()
    {
        $request = [
            "name" => "Sigma"
        ];

        $user = User::first();
        Passport::actingAs(
            $user,
            ["http://secrep.test/api/create_work_organizations"]
        );

        $response = $this->post("http://secrep.test/api/create_work_organizations", $request, ["X-Requested-With" => "XMLHttpRequest"])
        ->assertJsonStructure([
            "message"
        ]);// A "message"(just string) is my personal way of aknowledging if correct results are returned.
     
        $response->assertStatus(200);

    }

    public function test_list_work_organizations()
    {
        //Simulation of data entered by user.
        $request = [];

        //Simulation of passing on token.
        $user = User::first();
        Passport::actingAs(
            $user,
            ["http://secrep.test/api/list_work_organizations"]
        );

        //Simulation of post method via ajax request and checking if returned result have proper json structure.
        $response = $this->get("http://secrep.test/api/list_work_organizations", $request, ["X-Requested-With" => "XMLHttpRequest"]/*Test if request is ajax*/)
        ->assertJsonStructure([
            "message"
        ]);// A "message"(just string) is my personal way of aknowledging if correct results are returned.
     
        $response->assertStatus(200);

    }

    public function test_show_work_organization()
    {
        $request = [
            "id" => 4
        ];
        
        $user = User::first();
        Passport::actingAs(
            $user,
            ["http://secrep.test/api/show_work_organization"]
        );

        $response = $this->get("http://secrep.test/api/show_work_organization", $request, ["X-Requested-With" => "XMLHttpRequest"])
        ->assertJsonStructure([
            "message"
        ]);// A "message"(just string) is my personal way of aknowledging if correct results are returned.
     
        $response->assertStatus(200);

    }

    public function test_update_work_organization()
    {
        $request = [
            "id" => 4,
            "name" => "SigmaX",
            "sec_id" => 1
        ];

        $user = User::first();
        Passport::actingAs(
            $user,
            ["http://secrep.test/api/update_work_organization"]
        );

        $response = $this->patch("http://secrep.test/api/update_work_organization", $request, ["X-Requested-With" => "XMLHttpRequest"])
        ->assertJsonStructure([
            "message"
        ]);// A "message"(just string) is my personal way of aknowledging if correct results are returned.
     
        $response->assertStatus(200);

    }

    public function test_delete_work_organization()
    {
        $request = [
            "id" => 4
        ];

        $user = User::first();
        Passport::actingAs(
            $user,
            ["http://secrep.test/api/delete_work_organization"]
        );

        $response = $this->delete("http://secrep.test/api/delete_work_organization", $request, ["X-Requested-With" => "XMLHttpRequest"])
        ->assertJsonStructure([
            "message"
        ]);// A "message"(just string) is my personal way of aknowledging if correct results are returned.
     
        $response->assertStatus(200);

    }

}