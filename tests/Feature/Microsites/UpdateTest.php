<?php

namespace Tests\Feature\Microsites;

use App\Constants\CurrencyTypes;
use App\Constants\MicrositeTypes;
use App\Constants\Permissions;
use App\Infrastructure\Persistence\Models\Category;
use App\Infrastructure\Persistence\Models\Microsite;
use App\Infrastructure\Persistence\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_update_a_microsite(): void
    {
        $this->markTestSkipped();
        if (!Permission::where('name', Permissions::MICROSITES_UPDATE)->exists()) {
            Permission::create(['name' => Permissions::MICROSITES_UPDATE, 'guard_name' => 'web']);
        }

        $role = Role::findOrCreate('super_admin', 'web');
        $role->givePermissionTo(Permissions::MICROSITES_UPDATE);

        $user = User::factory()->create();

        $user->assignRole($role);
        $data = [
            'name' => 'technology',
            'slug' => 'technology',
            'logo' => 'description',
            'category_id' => Category::factory()->create()->id,
            'type' => MicrositeTypes::DONATION,
            'currency' => CurrencyTypes::COP,
            'payment_expiration' => 12
        ];

        $microsite = Microsite::factory()->create($data);

        $data['type'] = MicrositeTypes::INVOICE;
        $data['currency'] = 'USD';
        $data['payment_expiration'] = 30;

        $this->actingAs($user)
            ->patch(route('microsites.update', $microsite->id), $data)
            ->assertRedirect(route('microsites.index'));

        $data['id'] = $microsite->id;
        $this->assertDatabaseHas('microsites', $data);
    }

    public function test_can_not_update_microsite_if_is_not_authenticated(): void
    {
        $data = [
            'name' => 'technology',
            'slug' => 'technology',
            'logo' => 'description',
            'category_id' => Category::factory()->create()->id,
            'type' => MicrositeTypes::DONATION,
            'currency' => CurrencyTypes::COP,
            'payment_expiration' => 12
        ];

        $microsite = Microsite::factory()->create($data);

        $data['type'] = MicrositeTypes::INVOICE;
        $data['currency'] = 'USD';
        $data['payment_expiration'] = 30;

        $this->patch(route('microsites.update', $microsite->id), $data)
            ->assertRedirect(route('login'));

        $this->assertDatabaseMissing('microsites', [
            'name' => 'technology',
            'slug' => 'technology',
            'logo' => 'description',
            'category_id' => Category::factory()->create()->id,
            'type' => MicrositeTypes::DONATION,
            'currency' => 'COP',
            'payment_expiration' => 12
        ]);
    }
}
