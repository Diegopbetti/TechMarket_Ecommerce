<?php

namespace Tests\Unit;

use App\Models\Admin;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ModelsRelationshipAndBusinessTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_sensitive_attributes_are_hidden_in_serialization(): void
    {
        $user = User::factory()->create();
        $array = $user->toArray();

        $this->assertArrayNotHasKey('password', $array);
        $this->assertArrayNotHasKey('remember_token', $array);
    }

    public function test_product_belongs_to_announcer_user(): void
    {
        $seller = User::factory()->create();
        $product = Product::factory()->create(['announcer_id' => $seller->id]);

        $this->assertInstanceOf(User::class, $product->announcer);
        $this->assertEquals($seller->id, $product->announcer->id);
        $this->assertTrue($seller->announcer->contains($product));
    }

    public function test_transaction_links_buyer_seller_and_product_correctly(): void
    {
        $buyer = User::factory()->create();
        $seller = User::factory()->create();
        $product = Product::factory()->create([
            'announcer_id' => $seller->id,
            'price' => 250.00,
        ]);

        $transaction = Transaction::create([
            'reference_id' => 'REF-UNIT-001',
            'product_id' => $product->id,
            'buyer_id' => $buyer->id,
            'seller_id' => $seller->id,
            'product_quantity' => 2,
            'total_price' => 500.00,
            'date' => now(),
        ]);

        $this->assertEquals($buyer->id, $transaction->buyer->id);
        $this->assertEquals($seller->id, $transaction->seller->id);
        $this->assertEquals($product->id, $transaction->product->id);
        $this->assertInstanceOf(\Illuminate\Support\Carbon::class, $transaction->date);
    }

    public function test_admin_can_have_a_creator_admin_hierarchy(): void
    {
        $masterAdmin = Admin::factory()->create(['admin_id' => null]);
        $subAdmin = Admin::factory()->create(['admin_id' => $masterAdmin->id]);

        $this->assertInstanceOf(Admin::class, $subAdmin->creator);
        $this->assertEquals($masterAdmin->id, $subAdmin->creator->id);
    }
}