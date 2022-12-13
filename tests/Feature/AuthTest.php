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
class AuthTest extends TestCase
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
    
}
