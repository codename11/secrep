<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use Laravel\Passport\Passport;

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

class RolesTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_list_roles()
    {
        $request = [
            
        ];

        $user = User::first();
        Passport::actingAs(
            $user,
            ["http://secrep.test/api/list_roles"]
        );
        
        $req = $this->get("http://secrep.test/api/list_roles", $request, ["X-Requested-With" => "XMLHttpRequest"]);
        
        $response = $req->assertJsonStructure(["message"]);// A "message"(just string) is my personal way of aknowledging if correct results are returned.
     
        $response->assertStatus(200);

    }

    public function test_update_user_role()
    {
        $request = [
            "user_id" => 2,
            "new_role_id" => 2
        ];

        $user = User::first();
        Passport::actingAs(
            $user,
            ["http://secrep.test/api/update_user_role"]
        );
        
        $req = $this->patch("http://secrep.test/api/update_user_role", $request, ["X-Requested-With" => "XMLHttpRequest"]);
        
        $response = $req->assertJsonStructure(["message"]);// A "message"(just string) is my personal way of aknowledging if correct results are returned.
     
        $response->assertStatus(200);

    }

}
