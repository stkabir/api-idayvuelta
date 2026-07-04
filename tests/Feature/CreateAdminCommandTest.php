<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateAdminCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_an_admin_user(): void
    {
        $this->artisan('admin:create', [
            'name' => 'Admin Test',
            'email' => 'admin@test.com',
            'password' => 'securepassword123',
        ])
            ->assertSuccessful()
            ->expectsOutputToContain('Usuario administrador creado correctamente.');

        $user = User::where('email', 'admin@test.com')->first();

        $this->assertNotNull($user);
        $this->assertTrue($user->hasRole('admin'));
    }

    public function test_it_fails_with_invalid_email(): void
    {
        $this->artisan('admin:create', [
            'name' => 'Admin Test',
            'email' => 'not-an-email',
            'password' => 'securepassword123',
        ])
            ->assertFailed()
            ->expectsOutputToContain('El correo electrónico no es válido.');
    }

    public function test_it_fails_with_short_password(): void
    {
        $this->artisan('admin:create', [
            'name' => 'Admin Test',
            'email' => 'admin@test.com',
            'password' => '123',
        ])
            ->assertFailed()
            ->expectsOutputToContain('La contraseña debe tener al menos 8 caracteres.');
    }
}
