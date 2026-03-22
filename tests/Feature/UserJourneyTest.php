<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;


use Illuminate\Support\Facades\Http;

class UserJourneyTest extends TestCase


{
    use RefreshDatabase;



    public function test_user_can_register_with_valid_inputs()
    {
        Http::fake([
            'https://www.google.com/recaptcha/api/siteverify' => Http::response(['success' => true], 200)
        ]);

        $response = $this->post('/register', [
            'name' => 'John Doe',

            'email' => 'john@test.com',
            'password' => 'password123',


            'password_confirmation' => 'password123',
            'g-recaptcha-response' => 'test-token',
        ]);


        $this->assertDatabaseHas('users', [
            'email' => 'john@test.com'
        ]);
        $response->assertRedirect('/');
    }

    public function test_user_cannot_register_with_invalid_inputs()
    {
        Http::fake([
            'https://www.google.com/recaptcha/api/siteverify' => Http::response(['success' => true], 200)
        ]);

        $response = $this->post('/register', [
            'name' => '',
            'email' => 'not-an-email',
            'password' => 'short',
            'g-recaptcha-response' => 'test-token',
        ]);

        $response->assertSessionHasErrors(['name', 'email', 'password']);
    }

    public function test_user_can_login_with_correct_credentials()
    {
        Http::fake([
            'https://www.google.com/recaptcha/api/siteverify' => Http::response(['success' => true], 200)
        ]);

        $user = User::factory()->create([
            'password' => bcrypt($password = 'i-love-laravel'),
            

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $password,
            'g-recaptcha-response' => 'test-token',
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect('/');
    }

    public function test_account_lockout_after_five_attempts()
    {
        Http::fake([
            'https://www.google.com/recaptcha/api/siteverify' => Http::response(['success' => true], 200)
        ]);

        $user = User::factory()->create([
            'password' => bcrypt('correct-password'),
        ]);

        



        for ($i = 0; $i < 5; $i++) {
            $this->post('/login', [
                'email' => $user->email,
                'password' => 'wrong-password',
                'g-recaptcha-response' => 'test-token',
            ]);
        }

        // The 6th attempt  trigger a lockout response
        $response = $this->post('/login', [
            'email' => $user->email,

            'password' => 'wrong-password',
            'g-recaptcha-response' => 'test-token',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertStringContainsString('Too many login attempts', session('errors')->first('email'));
    }

    public function test_adding_product_to_basket()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create(['stock_quantity' => 10]);



        $response = $this->actingAs($user)->post("/addProduct/{$product->id}", [
            'quantity' => 2
        ]);


        $this->assertDatabaseHas('shopping_basket', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 2
        ]);
    }



    

    public function test_adding_product_to_wishlist_requires_authentication()
    {
        $product = Product::factory()->create();

        // Attempting to add without logging in
        $response = $this->post("/wishlist/add/{$product->id}"
    
    
    
    
    );
        
        // Assert redirected to the login page
        $response->assertRedirect('/login');
    }


    public function test_authenticated_user_can_add_to_wishlist()
    {
        $user = User::factory()->create();
        $product = Product::factory()->
        
        create();




        $response = $this->actingAs($user)->post("/wishlist/add/{$product->id}");

        $this->assertDatabaseHas('wishlist', [



            'user_id' => $user->id,
            'product_id' => $product->id
        ]);
    }
}
