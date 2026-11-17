<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_create_a_product_with_image(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('product.store'), [
            'name' => 'Notebook Gamer',
            'category' => 'Computadores',
            'price' => 4500.00,
            'description' => 'Notebook RTX 4060 16GB RAM',
            'photo' => UploadedFile::fake()->image('notebook.jpg'),
        ]);

        $response->assertRedirect(route('product_management'));
        $this->assertDatabaseHas('products', [
            'name' => 'Notebook Gamer',
            'category' => 'Computadores',
            'price' => 4500.00,
            'announcer_id' => $user->id,
        ]);
    }

    public function test_user_can_update_their_own_product(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create(['announcer_id' => $user->id]);

        $response = $this->actingAs($user)->put(route('product.update', $product->id), [
            'name' => 'Produto Atualizado',
            'category' => 'Celulares',
            'price' => 1999.90,
            'description' => 'Nova descrição atualizada',
        ]);

        $response->assertRedirect(route('product_management'));
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Produto Atualizado',
            'price' => 1999.90,
        ]);
    }

    public function test_user_cannot_update_or_delete_product_from_another_announcer(): void
    {
        $owner = User::factory()->create();
        $intruder = User::factory()->create();
        $product = Product::factory()->create(['announcer_id' => $owner->id]);

        // Tenta editar produto alheio -> Deve retornar 403 Forbidden
        $updateResponse = $this->actingAs($intruder)->put(route('product.update', $product->id), [
            'name' => 'Tentativa de Hack',
            'category' => 'TVs',
            'price' => 1.00,
            'description' => 'Descrição',
        ]);
        $updateResponse->assertStatus(403);

        // Tenta excluir produto alheio -> Deve retornar 403 Forbidden
        $deleteResponse = $this->actingAs($intruder)->delete(route('product.destroy', $product->id));
        $deleteResponse->assertStatus(403);

        // Garante que o produto continua intacto no banco
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => $product->name,
        ]);
    }
}