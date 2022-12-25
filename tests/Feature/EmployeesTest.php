<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Laravel\Passport\Passport;
use App\User;
use App\Vehicle;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

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

class EmployeesTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_create_employee()
    {
        Storage::fake('avatars');
        $file = UploadedFile::fake()->image("avatar.jpg");
        $request = [
            "firstName" => "Tebra1",
            "lastName" => "Tebric",
            "work_org_id" => 1,
            "sec_id" => 1,
            "avatar" => $file
        ];

        $user = User::first();
        Passport::actingAs(
            $user,
            ["http://secrep.test/api/create_employee"]
        );

        $response = $this->post("http://secrep.test/api/create_employee", $request, ["X-Requested-With" => "XMLHttpRequest"])
        ->assertJsonStructure([
            "message"
        ]);// A "message"(just string) is my personal way of aknowledging if correct results are returned.
     
        $response->assertStatus(200);

    }

    public function test_list_employees()
    {
        //Simulation of data entered by user.
        $request = [];

        //Simulation of passing on token.
        $user = User::first();
        Passport::actingAs(
            $user,
            ["http://secrep.test/api/list_employees"]
        );

        //Simulation of post method via ajax request and checking if returned result have proper json structure.
        $response = $this->get("http://secrep.test/api/list_employees", $request, ["X-Requested-With" => "XMLHttpRequest"]/*Test if request is ajax*/)
        ->assertJsonStructure([
            "message"
        ]);// A "message"(just string) is my personal way of aknowledging if correct results are returned.
     
        $response->assertStatus(200);

    }

    public function test_show_employee()
    {
        $request = [
            "id" => 14
        ];
        
        $user = User::first();
        Passport::actingAs(
            $user,
            ["http://secrep.test/api/show_employee"]
        );

        $response = $this->get("http://secrep.test/api/show_employee", $request, ["X-Requested-With" => "XMLHttpRequest"])
        ->assertJsonStructure([
            "message"
        ]);// A "message"(just string) is my personal way of aknowledging if correct results are returned.
     
        $response->assertStatus(200);

    }

    public function test_update_employee()
    {

        Storage::fake('avatars');
        $file = UploadedFile::fake()->image("avatar.jpg");
        $request = [
            "id" => 6,
            "firstName" => "Tebra",
            "lastName" => "Tebric",
            "work_org_id" => 1,
            "sec_id" => 1,
            "avatar" => $file
        ];

        $user = User::first();
        Passport::actingAs(
            $user,
            ["http://secrep.test/api/update_employee"]
        );

        $response = $this->patch("http://secrep.test/api/update_employee", $request, ["X-Requested-With" => "XMLHttpRequest"])
        ->assertJsonStructure([
            "message"
        ]);// A "message"(just string) is my personal way of aknowledging if correct results are returned.
     
        $response->assertStatus(200);

    }

    public function test_delete_employee()
    {
        $request = [
            "id" => 6
        ];

        $user = User::with("role")->first();
        Passport::actingAs(
            $user,
            ["http://secrep.test/api/delete_employee"]
        );

        $response = $this->delete("http://secrep.test/api/delete_employee", $request, ["X-Requested-With" => "XMLHttpRequest"])
        ->assertJsonStructure([
            "message"
        ]);// A "message"(just string) is my personal way of aknowledging if correct results are returned.
     
        $response->assertStatus(200);

    }

}