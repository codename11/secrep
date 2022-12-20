<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use Laravel\Passport\Passport;

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
