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

class UtilitiesTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create_per_page()
    {
        $request = [
            "user_id" => 1,
            "per_page" => 4,
        ];

        $user = User::first();
        Passport::actingAs(
            $user,
            ["http://secrep.test/api/create_per_page"]
        );
        
        $req = $this->post("http://secrep.test/api/create_per_page", $request, ["X-Requested-With" => "XMLHttpRequest"]);
        
        $response = $req->assertJsonStructure(["message"]);// A "message"(just string) is my personal way of aknowledging if correct results are returned.
     
        $response->assertStatus(200);

    }

    public function test_update_per_page()
    {
        $request = [
            "user_id" => 1,
            "per_page_id" => 2,
            "per_page" => 3,
        ];

        $user = User::first();
        Passport::actingAs(
            $user,
            ["http://secrep.test/api/update_per_page"]
        );
        
        $req = $this->patch("http://secrep.test/api/update_per_page", $request, ["X-Requested-With" => "XMLHttpRequest"]);
        
        $response = $req->assertJsonStructure(["message"]);// A "message"(just string) is my personal way of aknowledging if correct results are returned.
     
        $response->assertStatus(200);

    }

}
