<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class UserJourneyTest extends TestCase
{
    use RefreshDatabase;

    // ─── Authentication Tests ──────────────────────────────────────────────────

    /**
     * @test
     * A valid user can register successfully and is redirected home.
     */
    public function test_user_can_register_with_valid_inputs()
    {
        Http::fake([
            'https://www.google.com/recaptcha/api/siteverify' => Http::response(['success' => true], 200)
        ]);

        $response = $this->post('/register', [
            'name'                  => 'John Doe',
            'email'                 => 'john@test.com',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
            'g-recaptcha-response'  => 'test-token',
        ]);

        $this->assertDatabaseHas('users', ['email' => 'john@test.com']);
        $response->assertRedirect('/');
    }

    /**
     * @test
     * Registration fails with validation errors on invalid inputs.
     */
    public function test_user_cannot_register_with_invalid_inputs()
    {
        Http::fake([
            'https://www.google.com/recaptcha/api/siteverify' => Http::response(['success' => true], 200)
        ]);

        $response = $this->post('/register', [
            'name'                 => '',
            'email'                => 'not-an-email',
            'password'             => 'short',
            'g-recaptcha-response' => 'test-token',
        ]);

        $response->assertSessionHasErrors(['name', 'email', 'password']);
    }

    /**
     * @test
     * A registered user can log in and is redirected to the home page.
     */
    public function test_user_can_login_with_correct_credentials()
    {
        Http::fake([
            'https://www.google.com/recaptcha/api/siteverify' => Http::response(['success' => true], 200)
        ]);

        $user = User::factory()->create([
            'password' => bcrypt($password = 'i-love-laravel'),
        ]);

        $response = $this->post('/login', [
            'email'                => $user->email,
            'password'             => $password,
            'g-recaptcha-response' => 'test-token',
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect('/');
    }

    /**
     * @test
     * Login fails with wrong password and generates a session error.
     */
    public function test_user_cannot_login_with_wrong_password()
    {
        Http::fake([
            'https://www.google.com/recaptcha/api/siteverify' => Http::response(['success' => true], 200)
        ]);

        $user = User::factory()->create([
            'password' => bcrypt('correct-password'),
        ]);

        $response = $this->post('/login', [
            'email'                => $user->email,
            'password'             => 'wrong-password',
            'g-recaptcha-response' => 'test-token',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('email');
    }

    /**
     * @test
     * Account is locked after 5 failed login attempts (rate-limiting).
     */
    public function test_account_lockout_after_five_failed_attempts()
    {
        Http::fake([
            'https://www.google.com/recaptcha/api/siteverify' => Http::response(['success' => true], 200)
        ]);

        $user = User::factory()->create([
            'password' => bcrypt('correct-password'),
        ]);

        for ($i = 0; $i < 5; $i++) {
            $this->post('/login', [
                'email'                => $user->email,
                'password'             => 'wrong-password',
                'g-recaptcha-response' => 'test-token',
            ]);
        }

        // 6th attempt should trigger rate limit
        $response = $this->post('/login', [
            'email'                => $user->email,
            'password'             => 'wrong-password',
            'g-recaptcha-response' => 'test-token',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertStringContainsString(
            'Too many login attempts',
            session('errors')->first('email')
        );
    }

    // ─── Basket Tests ──────────────────────────────────────────────────────────

    /**
     * @test
     * An authenticated user can add a product to their basket.
     */
    public function test_authenticated_user_can_add_product_to_basket()
    {
        $user    = User::factory()->create();
        $product = Product::factory()->create(['stock_quantity' => 10]);

        $response = $this->actingAs($user)->post("/addProduct/{$product->id}", [
            'quantity' => 2,
        ]);

        $this->assertDatabaseHas('shopping_basket', [
            'user_id'    => $user->id,
            'product_id' => $product->id,
            'quantity'   => 2,
        ]);
    }

    /**
     * @test
     * A guest user is redirected to login when trying to add to basket.
     */
    public function test_guest_cannot_add_product_to_basket()
    {
        $product = Product::factory()->create();

        $response = $this->post("/addProduct/{$product->id}", ['quantity' => 1]);

        $response->assertRedirect('/login');
    }

    /**
     * @test
     * Quantity updates correctly in the basket.
     */
    public function test_user_can_update_basket_quantity()
    {
        $user    = User::factory()->create();
        $product = Product::factory()->create();

        // Add to basket first
        DB::table('shopping_basket')->insert([
            'user_id'    => $user->id,
            'product_id' => $product->id,
            'quantity'   => 1,
        ]);

        $basketId = DB::table('shopping_basket')->where('user_id', $user->id)->value('id');

        $this->actingAs($user)->post("/updateQuantity/{$basketId}", ['quantity' => 4]);

        $this->assertDatabaseHas('shopping_basket', [
            'id'       => $basketId,
            'quantity' => 4,
        ]);
    }

    /**
     * @test
     * A user can remove a product from their basket.
     */
    public function test_user_can_remove_product_from_basket()
    {
        $user    = User::factory()->create();
        $product = Product::factory()->create();

        DB::table('shopping_basket')->insert([
            'user_id'    => $user->id,
            'product_id' => $product->id,
            'quantity'   => 1,
        ]);

        $basketId = DB::table('shopping_basket')->where('user_id', $user->id)->value('id');

        $this->actingAs($user)->post("/removeProduct/{$basketId}");

        $this->assertDatabaseMissing('shopping_basket', ['id' => $basketId]);
    }

    // ─── Wishlist Tests ────────────────────────────────────────────────────────

    /**
     * @test
     * Unauthenticated users are redirected to login when accessing wishlist.
     */
    public function test_adding_to_wishlist_requires_authentication()
    {
        $product = Product::factory()->create();

        $response = $this->post("/wishlist/add/{$product->id}");

        $response->assertRedirect('/login');
    }

    /**
     * @test
     * An authenticated user can add a product to their wishlist.
     */
    public function test_authenticated_user_can_add_to_wishlist()
    {
        $user    = User::factory()->create();
        $product = Product::factory()->create();

        $response = $this->actingAs($user)->post("/wishlist/add/{$product->id}");

        $this->assertDatabaseHas('wishlist', [
            'user_id'    => $user->id,
            'product_id' => $product->id,
        ]);
    }

    // ─── Product / Search Tests ────────────────────────────────────────────────

    /**
     * @test
     * A product page loads successfully for a valid product ID.
     */
    public function test_product_page_loads_successfully()
    {
        $product = Product::factory()->create(['is_available' => true]);

        $response = $this->get("/product/{$product->id}");

        $response->assertStatus(200);
    }

    /**
     * @test
     * The search endpoint returns results matching the product name.
     */
    public function test_search_returns_matching_products()
    {
        Product::factory()->create([
            'name'         => 'Unique Washing Machine',
            'is_available' => true,
        ]);

        $response = $this->get('/search?query=Unique+Washing+Machine');

        $response->assertStatus(200);
        $response->assertSee('Unique Washing Machine');
    }

    /**
     * @test
     * An empty search query redirects back with an error.
     */
    public function test_empty_search_redirects_with_error()
    {
        $response = $this->get('/search?query=');

        $response->assertRedirect();
        $response->assertSessionHas('error');
    }

    // ─── Access Control Tests ──────────────────────────────────────────────────

    /**
     * @test
     * Non-admin users are forbidden from accessing the admin dashboard.
     */
    public function test_normal_user_cannot_access_admin_dashboard()
    {
        $user = User::factory()->create(['is_admin' => false]);

        $response = $this->actingAs($user)->get('/admin/dashboard');

        $response->assertStatus(403);
    }

    /**
     * @test
     * Admin users can access the admin dashboard.
     */
    public function test_admin_can_access_admin_dashboard()
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->get('/admin/dashboard');

        $response->assertStatus(200);
    }
}
