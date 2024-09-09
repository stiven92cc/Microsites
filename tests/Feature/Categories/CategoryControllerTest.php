<?php

namespace Tests\Feature\Categories;

use App\Constants\Permissions;
use App\Infrastructure\Persistence\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_store_category(): void
    {
        if (!Permission::where('name', Permissions::CATEGORIES_STORE)->exists()) {
            Permission::create(['name' => Permissions::CATEGORIES_STORE, 'guard_name' => 'web']);
        }

        $role = Role::findOrCreate('super_admin', 'web');
        $role->givePermissionTo(Permissions::CATEGORIES_STORE);

        $user = User::factory()->create();

        $user->assignRole($role);
        $data = [
            'name' => 'technology',
            'alias' => 'technology',
            'description' => 'description'
        ];
        $response = $this->actingAs($user)
            ->post(route('categories.store'), $data)
            ->assertRedirect(route('categories.index'));

        $this->assertDatabaseHas('categories', [
            'name' => $data['name'],
            'alias' => $data['alias'],
            'description' => $data['description'],
        ]);

        $response->assertRedirect(route('categories.index'));
    }

    public function test_can_not_store_category_if_is_not_authenticated(): void
    {
        $data = [
            'name' => 'technology',
            'alias' => 'technology',
            'description' => 'description'
        ];

        $this->post(route('categories.store'), $data)
            ->assertRedirect(route('login'));

        $this->assertDatabaseMissing('categories', [
            'name' => $data['name'],
            'alias' => $data['alias'],
            'description' => $data['description'],
        ]);
    }


    #[DataProvider('invalidData')]
    public function test_can_not_store_category_if_has_invalid_data($key, $value): void
    {
        $user = User::factory()->create();
        $data = [
            'name' => 'technology',
            'alias' => 'technology',
            'description' => 'description'
        ];
        $data[$key] = $value;

        $response = $this->actingAs($user)
            ->post(route('categories.store'), $data);

        $response->assertSessionHasErrors();

        $this->assertDatabaseMissing('categories', [
            'name' => $data['name'],
            'alias' => $data['alias'],
            'description' => $data['description'],
        ]);

    }

    public static function invalidData(): array
    {
        return [
            'name should be required' => [
                'key' => 'name',
                'value' => null,
            ],
            'name should be string' => [
                'key' => 'name',
                'value' => 12345,
            ],
            'alias should be required' => [
                'key' => 'alias',
                'value' => null,
            ],
            'description should be required' => [
                'key' => 'description',
                'value' => null,
            ],
            'description should be string' => [
                'key' => 'description',
                'value' => 12345,
            ],
        ];
    }
}
