<?php

namespace Tests\Feature;

use App\Models\User;
use Filament\Auth\Pages\Login;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * Regresi: RoleBasedLoginResponse harus valid dalam konteks Livewire
 * (redirect() mengembalikan Redirector, bukan RedirectResponse).
 */
class UnifiedLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_developer_is_redirected_to_developer_panel_after_login(): void
    {
        $this->assertLoginRedirectsTo(User::factory()->developer()->create(), '/developer');
    }

    public function test_administrator_is_redirected_to_admin_panel_after_login(): void
    {
        $this->assertLoginRedirectsTo(User::factory()->administrator()->create(), '/admin');
    }

    public function test_participant_is_redirected_to_participant_panel_after_login(): void
    {
        $this->assertLoginRedirectsTo(User::factory()->participant()->create(), '/participant');
    }

    public function test_logout_redirects_to_unified_login(): void
    {
        $this->actingAs(User::factory()->participant()->create());

        $this->post('/participant/logout')->assertRedirect(route('login'));
    }

    private function assertLoginRedirectsTo(User $user, string $path): void
    {
        Filament::setCurrentPanel(Filament::getPanel('participant'));

        Livewire::test(Login::class)
            ->fillForm([
                'email' => $user->email,
                'password' => 'password',
            ])
            ->call('authenticate')
            ->assertHasNoFormErrors()
            ->assertRedirect(url($path));

        $this->assertAuthenticatedAs($user);
    }
}
