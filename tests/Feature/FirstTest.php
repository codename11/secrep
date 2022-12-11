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
/*
php artisan cache:clear
php artisan route:clear
php artisan config:clear
php artisan view:clear
*/
class FirstTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_register()
    {

        Passport::actingAsClient(
            factory(User::class)->create(),
            ["http://secrep.test/api/register"]
        );
     
        $response = $this->post("http://secrep.test/api/register");
     
        $response->assertStatus(302);

    }

    public function test_login()
    {

        Passport::actingAsClient(
            factory(User::class)->create(),
            ["http://secrep.test/api/login"]
        );
     
        $response = $this->post("http://secrep.test/api/login");
     
        $response->assertStatus(302);

    }
    
    public function test_logout()
    {

        Passport::actingAs(
            factory(User::class)->create(),
            ["http://secrep.test/api/logout"]
        );
     
        $response = $this->post("http://secrep.test/api/logout");
     
        $response->assertStatus(200);

    }

    public function test_list_vehicles()
    {
        //Simulation of data entered by user.
        $request = [
            "type" => "truck",
            "workOrg" => "alpha"
        ];

        //Simulation of passing on token.
        Passport::actingAs(
            factory(User::class)->create(),
            ["http://secrep.test/api/list_vehicles"]
        );

        //Simulation of post method via ajax request and checking if returned result have proper json structure.
        $response = $this->post("http://secrep.test/api/list_vehicles", $request, ["X-Requested-With" => "XMLHttpRequest"]/*Test if request is ajax*/)
        ->assertJsonStructure([
            "message",
            "vehicles" => [
                [
                    "id",
                    "registration",
                    "sec_id",
                    "created_at",
                    "updated_at",
                    "vehicle_type_id",
                    "workOrganization_id",
                    "special_permission_id",
                    "deleted_at",
                    "work_organization" => [
                        "id",
                        "name",
                        "sec_id",
                        "created_at",
                        "updated_at",
                        "deleted_at"
                    ],
                    "type" => [
                        "id",
                        "name",
                        "created_at",
                        "updated_at",
                        "deleted_at"
                    ]
                ]
            ]
        ]);// A "message"(just string) is my personal way of aknowledging if correct results are returned.
     
        $response->assertStatus(200);

    }

    public function test_create_vehicle()
    {
        $request = [
            "registration" => "KamionX",
            "vehicle_type_id" => 1,
            "workOrg" => 1
        ];

        Passport::actingAs(
            factory(User::class)->create(["role_id" => 1]),
            ["http://secrep.test/api/create_vehicle"]
        );

        $response = $this->post("http://secrep.test/api/create_vehicle", $request, ["X-Requested-With" => "XMLHttpRequest"])
        ->assertJsonStructure([
            "message"
        ]);// A "message"(just string) is my personal way of aknowledging if correct results are returned.
     
        $response->assertStatus(200);

    }

    public function test_show_vehicle()
    {
        $request = [
            "id" => 14
        ];

        Passport::actingAs(
            factory(User::class)->create(["role_id" => 1]),
            ["http://secrep.test/api/show_vehicle"]
        );

        $response = $this->get("http://secrep.test/api/show_vehicle", $request, ["X-Requested-With" => "XMLHttpRequest"])
        ->assertJsonStructure([
            "message"
        ]);// A "message"(just string) is my personal way of aknowledging if correct results are returned.
     
        $response->assertStatus(200);

    }

    public function test_update_vehicle()
    {
        $request = [
            "id" => 14,
            "registration" => "KamionXYZ"
        ];

        Passport::actingAs(
            factory(User::class)->create(["role_id" => 1]),
            ["http://secrep.test/api/update_vehicle"]
        );

        $response = $this->patch("http://secrep.test/api/update_vehicle", $request, ["X-Requested-With" => "XMLHttpRequest"])
        ->assertJsonStructure([
            "message"
        ]);// A "message"(just string) is my personal way of aknowledging if correct results are returned.
     
        $response->assertStatus(200);

    }

    public function test_delete_vehicle()
    {
        $request = [
            "id" => 14
        ];

        Passport::actingAs(
            factory(User::class)->create(["role_id" => 1]),
            ["http://secrep.test/api/delete_vehicle"]
        );

        $response = $this->delete("http://secrep.test/api/delete_vehicle", $request, ["X-Requested-With" => "XMLHttpRequest"])
        ->assertJsonStructure([
            "message"
        ]);// A "message"(just string) is my personal way of aknowledging if correct results are returned.
     
        $response->assertStatus(200);

    }
    
}
