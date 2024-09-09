<?php

namespace Tests\Feature\Microsites;

use App\Constants\Permissions;
use App\Infrastructure\Persistence\Models\Microsite;
use App\Infrastructure\Persistence\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_delete_microsite(): void
    {
        if (!Permission::where('name', Permissions::MICROSITES_DESTROY)->exists()) {
            Permission::create(['name' => Permissions::MICROSITES_DESTROY, 'guard_name' => 'web']);
        }

        $role = Role::findOrCreate('super_admin', 'web');
        $role->givePermissionTo(Permissions::MICROSITES_DESTROY);

        $user = User::factory()->create();

        $user->assignRole($role);

        $microsite = Microsite::factory()->create();

        $this->actingAs($user)
            ->delete(route('microsites.destroy', $microsite->id))
            ->assertRedirect(route('microsites.index'));

        $this->assertDatabaseMissing('microsites', ['id' => $microsite->id]);

    }
}
