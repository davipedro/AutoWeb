<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_admin_can_authenticate_using_the_login_screen(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->post('/login', [
            'email' => $admin->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticatedAs($admin);
        $response->assertRedirect(route('admin.dashboard', absolute: false));
    }

    public function test_seller_can_authenticate_using_the_login_screen(): void
    {
        $seller = User::factory()->create([
            'role' => 'seller',
        ]);

        $response = $this->post('/login', [
            'email' => $seller->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticatedAs($seller);
        $response->assertRedirect(route('seller.dashboard', absolute: false));
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function test_users_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }

    public function test_non_admin_cannot_access_admin_dashboard()
    {
        $seller = User::factory()->create(['role' => 'seller']);

        $response = $this->actingAs($seller)->get('/admin/dashboard');

        $response->assertRedirect();
        $response->assertSessionHas('error', 'Acesso negado');
    }

    public function test_guest_cannot_access_admin_dashboard()
    {
        $response = $this->get('/admin/dashboard');

        $response->assertRedirect('/login');
    }
}
