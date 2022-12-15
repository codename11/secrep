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
