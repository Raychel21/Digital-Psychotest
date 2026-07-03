<?php

namespace Tests\Feature;

use App\Models\User;
use Filament\Facades\Filament;
use Filament\Panel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PanelAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_developer_can_access_developer_admin_and_participant_panels(): void
    {
        $developer = User::factory()->developer()->create();

        $this->assertTrue($developer->canAccessPanel($this->panel('developer')));
        $this->assertTrue($developer->canAccessPanel($this->panel('admin')));
        $this->assertTrue($developer->canAccessPanel($this->panel('participant')));
    }

    public function test_administrator_can_access_admin_panel_but_not_developer_panel(): void
    {
        $administrator = User::factory()->administrator()->create();

        $this->assertFalse($administrator->canAccessPanel($this->panel('developer')));
        $this->assertTrue($administrator->canAccessPanel($this->panel('admin')));
        $this->assertTrue($administrator->canAccessPanel($this->panel('participant')));
    }

    public function test_participant_can_only_access_participant_panel(): void
    {
        $participant = User::factory()->participant()->create();

        $this->assertFalse($participant->canAccessPanel($this->panel('developer')));
        $this->assertFalse($participant->canAccessPanel($this->panel('admin')));
        $this->assertTrue($participant->canAccessPanel($this->panel('participant')));
    }

    private function panel(string $id): Panel
    {
        return Filament::getPanel($id);
    }
}
