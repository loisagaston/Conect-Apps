<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class AuthTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
   /**
 * @test
 * Test registration
 */
public function testRegister(){
    $response = $this->withoutExceptionHandling();
    //User's data
    $data = [
        'email' => 'test@gmail.com',
        'name' => 'Test',
        'password' => 'secret1234'
    ];
    //Send post request
    $response = $this->json('POST',route('api.register'),$data);
    //Assert it was successful

    //Delete data
    User::where('email','test@gmail.com')->delete();

/**
 * @test
 * Test login
 */

}


public function testLogin()
{
    //Create user
    User::create([
        'name' => 'test',
        'email'=>'test@gmail.com',
        'password' => bcrypt('secret1234')
    ]);
    //attempt login
    $response = $this->json('POST',route('api.authenticate'),[
        'email' => 'test@gmail.com',
        'password' => 'secret1234',
    ]);
    //Assert it was successful and a token was received
    $response->assertStatus(200);

    //Delete the user
    User::where('email','test@gmail.com')->delete();
}
}
