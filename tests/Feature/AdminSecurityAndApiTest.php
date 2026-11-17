<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminSecurityAndApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_regular_user_cannot_access_admin_routes(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'web')->get(route('admin_management'));

        $response->assertRedirect(route('login'));
    }

    public function test_admin_can_only_delete_admins_they_created_or_themselves(): void
    {
        $adminCreator = Admin::factory()->create(['admin_id' => null]);
        $otherAdmin = Admin::factory()->create(['admin_id' => null]);
        $subordinateAdmin = Admin::factory()->create(['admin_id' => $adminCreator->id]);

        // otherAdmin tenta deletar subordinateAdmin (que foi criado por adminCreator) -> Deve falhar
        $failResponse = $this->actingAs($otherAdmin, 'admin')
            ->delete(route('admin.destroy', $subordinateAdmin->id));

        $failResponse->assertSessionHasErrors([
            'error' => 'Você não tem permissão para excluir este administrador.',
        ]);
        $this->assertDatabaseHas('admins', ['id' => $subordinateAdmin->id]);

        // adminCreator deleta subordinateAdmin -> Deve funcionar
        $successResponse = $this->actingAs($adminCreator, 'admin')
            ->delete(route('admin.destroy', $subordinateAdmin->id));

        $this->assertDatabaseMissing('admins', ['id' => $subordinateAdmin->id]);
    }

    public function test_api_show_user_returns_paginated_json_structure(): void
    {
        User::factory()->count(8)->create();

        // Como o controller usa $_GET['page'] diretamente, definimos a superglobal para o teste
        $_GET['page'] = 1;

        $response = $this->getJson('/api/showUser?page=1');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'users',
                'total_pages',
                'status',
            ])
            ->assertJsonPath('total_pages', 2)
            ->assertJsonCount(6, 'users');
    }
}