<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminRenewableFacilityTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_from_admin_renewable_facilities(): void
    {
        $this->get(route('admin.renewable-facilities.index'))
            ->assertRedirect(route('login'));
    }

    public function test_non_admin_receives_forbidden(): void
    {
        $user = User::factory()->create(['is_admin' => false]);

        $this->actingAs($user)
            ->get(route('admin.renewable-facilities.index'))
            ->assertForbidden();
    }

    public function test_admin_can_open_index(): void
    {
        $user = User::factory()->create(['is_admin' => true]);

        $this->actingAs($user)
            ->get(route('admin.renewable-facilities.index'))
            ->assertOk()
            ->assertSee('再エネ施設の管理', false);
    }
}
