<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Laravel\Passport\Passport;
use App\User;
use App\Vehicle;
  
//https://www.bacancytechnology.com/blog/feature-testing-in-laravel
//php artisan test
//https://laravel.com/docs/5.1/testing
//https://laravel-news.com/how-to-start-testing
//https://www.youtube.com/watch?v=J0OFwSk9iV8&ab_channel=Laraveller
//DELETE FROM `users` WHERE id not in ('1','41')
//DELETE FROM `vehicles` WHERE id NOT BETWEEN 1 AND 15
//$user1 = User::where("id", "=", 1)->get();
//$user2 = ["id" => 1, "name" => "veljko", "email" => "veljkos82@gmail.com", "role_id" => 1, "email_verified_at" => null, "password" => '$2y$10$BWieAhdzRxUX4ndW.6Ki4u8eix5AtYhOJl6dB4YbVAAZr8xg/IXTa', "remember_token" => null, "created_at" => "2012-07-17 17:18:59", "updated_at" => "2022-12-07 17:20:58", "special_permission_id" => 1, "deleted_at" => null];
/*
php artisan cache:clear
php artisan route:clear
php artisan config:clear
php artisan view:clear
*/
//Target specific test: php artisan test --filter *nameoftest*
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

        Passport::actingAs(
            factory(User::class)->create(["role_id" => 1]),
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
        Passport::actingAs(
            factory(User::class)->create(),
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
            "id" => 1
        ];
        
        Passport::actingAs(
            factory(User::class)->create(["role_id" => 1]),
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
            "id" => 1,
            "name" => "Alpha",
            "sec_id" => 1
        ];

        Passport::actingAs(
            factory(User::class)->create(["role_id" => 1]),
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
            "id" => 1
        ];

        Passport::actingAs(
            factory(User::class)->create(["role_id" => 1]),
            ["http://secrep.test/api/delete_work_organization"]
        );

        $response = $this->delete("http://secrep.test/api/delete_work_organization", $request, ["X-Requested-With" => "XMLHttpRequest"])
        ->assertJsonStructure([
            "message"
        ]);// A "message"(just string) is my personal way of aknowledging if correct results are returned.
     
        $response->assertStatus(200);

    }

}