<?php

namespace Tests\Feature;

use App\Mail\Contact;
use App\Models\Admin;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class CheckoutAndMailMockTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_cannot_buy_their_own_product(): void
    {
        $seller = User::factory()->create();
        $product = Product::factory()->create([
            'announcer_id' => $seller->id,
            'quantity' => 5,
        ]);

        $response = $this->actingAs($seller)->post('/checkout', [
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        $response->assertSessionHasErrors([
            'error' => 'Você não pode comprar seu próprio produto.',
        ]);
    }

    public function test_user_cannot_buy_quantity_greater_than_available_stock(): void
    {
        $seller = User::factory()->create();
        $buyer = User::factory()->create();
        $product = Product::factory()->create([
            'announcer_id' => $seller->id,
            'quantity' => 2,
        ]);

        $response = $this->actingAs($buyer)->post('/checkout', [
            'product_id' => $product->id,
            'quantity' => 3,
        ]);

        $response->assertSessionHasErrors([
            'error' => 'Quantidade solicitada maior que o estoque disponível.',
        ]);
    }

    public function test_successful_pagseguro_checkout_creates_transaction_updates_balance_and_stock(): void
    {
        Config::set('services.pagseguro.checkout_url', 'https://sandbox.api.pagseguro.com/checkouts');
        Config::set('services.pagseguro.token', 'fake-token-123');

        // Dublê de Teste (Mock HTTP) simulando resposta 200 OK da API do PagSeguro
        Http::fake([
            'https://sandbox.api.pagseguro.com/*' => Http::response([
                'reference_id' => 'REF-PAGSEGURO-999',
                'links' => [
                    ['rel' => 'SELF', 'href' => 'https://sandbox.pagseguro.com/self'],
                    ['rel' => 'PAY', 'href' => 'https://sandbox.pagseguro.com/pay/checkout-link'],
                ],
            ], 200),
        ]);

        $seller = User::factory()->create(['balance' => 100.00]);
        $buyer = User::factory()->create(['balance' => 1000.00]);
        $product = Product::factory()->create([
            'announcer_id' => $seller->id,
            'price' => 250.00,
            'quantity' => 5,
        ]);

        $response = $this->actingAs($buyer)->post('/checkout', [
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        // Verifica redirecionamento externo para o PagSeguro
        $response->assertRedirect('https://sandbox.pagseguro.com/pay/checkout-link');

        // Verifica se a transação foi gravada corretamente (2 * 250 = 500)
        $this->assertDatabaseHas('transactions', [
            'reference_id' => 'REF-PAGSEGURO-999',
            'product_id' => $product->id,
            'buyer_id' => $buyer->id,
            'seller_id' => $seller->id,
            'product_quantity' => 2,
            'total_price' => 500.00,
        ]);

        // Verifica incremento do saldo do vendedor (100 + 500 = 600) e baixa de estoque (5 - 2 = 3)
        $this->assertEquals(600.00, $seller->fresh()->balance);
        $this->assertEquals(3, $product->fresh()->quantity);
    }

    public function test_admin_can_send_contact_email_using_mail_fake(): void
    {
        Mail::fake();

        $admin = Admin::factory()->create(['admin_id' => null]);

        $response = $this->actingAs($admin, 'admin')->post(route('contact.store'), [
            'recipient_email' => 'cliente@exemplo.com',
            'subject' => 'Aviso de Segurança',
            'message' => 'Sua conta foi verificada.',
        ]);

        $response->assertRedirect(route('contact.index'));
        $response->assertSessionHas('success', 'E-mail enviado com sucesso!');

        Mail::assertSent(Contact::class, function ($mail) {
            return $mail->hasTo('cliente@exemplo.com');
        });
    }
}