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

class CustomReportsTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_custom_reports_vehicles()
    {
        $request = [
            "start_date" => "17/09/2021 00:00",
            "end_date" => "30/09/2022 00:00",
            "vehicle_id" => 1,
            "vehicle" => [
                "user",
                "complements",
                "type",
                "workOrganization",
                "deliveries"
            ]
        ];

        $user = User::first();
        Passport::actingAs(
            $user,
            ["http://secrep.test/api/vehicles"]
        );
        
        $req = $this->post("http://secrep.test/api/vehicles", $request, ["X-Requested-With" => "XMLHttpRequest"]);
        
        $response = $req->assertJsonStructure(["message"]);// A "message"(just string) is my personal way of aknowledging if correct results are returned.
     
        $response->assertStatus(200);

    }

    public function test_custom_reports_deliveries()
    {
        $request = [
            "start_date" => "17/09/2021 00:00",
            "end_date" => "30/09/2022 00:00",
            "vehicle_id" => 1,
            "delivery" => [
                "operator",
                "enteredBy",
                "complement"
            ]
        ];

        $user = User::first();
        Passport::actingAs(
            $user,
            ["http://secrep.test/api/deliveries"]
        );
        
        $req = $this->post("http://secrep.test/api/deliveries", $request, ["X-Requested-With" => "XMLHttpRequest"]);
        
        $response = $req->assertJsonStructure(["message"]);// A "message"(just string) is my personal way of aknowledging if correct results are returned.
     
        $response->assertStatus(200);

    }

    public function test_custom_reports_employees()
    {
        $request = [
            "start_date" => "17/09/2021 00:00",
            "end_date" => "30/09/2022 00:00",
            "employee_id" => 1,
            "employee" => [
                "work_organization",
                "enteredBy",
                "deliveries"
            ]
        ];

        $user = User::first();
        Passport::actingAs(
            $user,
            ["http://secrep.test/api/employees"]
        );
        
        $req = $this->post("http://secrep.test/api/employees", $request, ["X-Requested-With" => "XMLHttpRequest"]);
        
        $response = $req->assertJsonStructure(["message"]);// A "message"(just string) is my personal way of aknowledging if correct results are returned.
     
        $response->assertStatus(200);

    }

    public function test_custom_reports_users()
    {
        $request = [
            "start_date" => "17/09/2021 00:00",
            "end_date" => "30/09/2022 00:00",
            "user_id" => 1,
            "user" => [
                "role",
                "vehicles",
                "deliveries",
                "complement",
                "delivery_details",
                "special_permissions",
                "employees",
                "utility"
            ]
        ];

        $user = User::first();
        Passport::actingAs(
            $user,
            ["http://secrep.test/api/users"]
        );
        
        $req = $this->post("http://secrep.test/api/users", $request, ["X-Requested-With" => "XMLHttpRequest"]);
        
        $response = $req->assertJsonStructure(["message"]);// A "message"(just string) is my personal way of aknowledging if correct results are returned.
     
        $response->assertStatus(200);

    }

}
