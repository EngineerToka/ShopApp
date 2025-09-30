<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
     use RefreshDatabase; 

    public function test_user_can_register()
    {
        $user = User::factory()->raw();
          // Add required fields
    $user['password_confirmation'] = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'; // match the password in factory
    $user['role'] = 'customer'; // or whatever default role you allow

    // Make sure password in factory is plain-text for testing
    // $user['password'] = 'password';
        $response = $this->postJson('/api/register', $user)
            ->assertStatus(201)
            ->assertJson(['success' => true]);
        $response->dump();
            
    }
    public function test_user_can_login()
    {
        $user = User::factory()->create();
        $loginData=[
            'email'=>$user['email'],
            'password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi' // assuming the factory sets this password
         ];
        
         $response = $this->postJson('/api/login', $loginData)
            ->assertJson(['success' => true]);
        $response->dump();


}
}
