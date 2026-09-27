<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Client\ConnectionException;

class PagSeguroController extends Controller
{   
    public function createCheckout(Request $request)
    {
        // Validação dos dados
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1|max:99',
        ]);

        $product = Product::findOrFail($request->input('product_id'));
        $seller = User::findOrFail($product->announcer_id);
        $buyerId = auth()->id();
        $quantity = $request->input('quantity');

        //Impede que o comprador e o vendedor sejam o mesmo user
        if ($product->announcer_id == $buyerId) {
            return redirect()->back()->withErrors([
                'error' => 'Você não pode comprar seu próprio produto.'
            ]);
        }

        if ($quantity > $product->quantity) {
            return redirect()->back()->withErrors([
                'error' => 'Quantidade solicitada maior que o estoque disponível.'
            ]);
        }

        $totalPrice = $product->price * $quantity;

        $referenceId = uniqid();

        // Configurações do PagSeguro
        $url = config('services.pagseguro.checkout_url');
        $token = config('services.pagseguro.token');

        // Dados para o PagSeguro
        $items = [
            [
                'name' => $product->name,
                'quantity' => $quantity,
                'unit_amount' => (int)($product->price * 100),
            ],
        ];

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json',
            ])->withoutVerifying()->post($url, [
                'reference_id' => $referenceId,
                'items' => $items,
            ]);
        } catch (ConnectionException $e) {
            return redirect()->route('erro')->withErrors([
                'error' => 'Não foi possível conectar ao serviço de pagamento. Tente novamente mais tarde.',
            ]);
        }

        // Verifica se a requisição foi bem-sucedida
        if ($response->successful()) {
            $payLink = data_get($response->json(), 'links.1.href');

            if (!$payLink) {
                return redirect()->route('erro')->withErrors([
                    'error' => 'Erro ao processar o pagamento. Tente novamente mais tarde.',
                ]);
            }

            DB::transaction(function () use ($product, $seller, $quantity, $totalPrice, $referenceId, $response, $buyerId) {
                Transaction::create([
                    'reference_id' => $response->json()['reference_id'] ?? $referenceId,
                    'product_id' => $product->id,
                    'buyer_id' => $buyerId,
                    'seller_id' => $product->announcer_id,
                    'product_quantity' => $quantity,
                    'total_price' => $totalPrice,
                    'date' => now(),
                ]);

                $seller->increment('balance', $totalPrice);

                $product->decrement('quantity', $quantity);
            });

            // Redireciona para o link de pagamento do PagSeguro
            return redirect()->away($payLink);
        }

        // Tratamento de erro
        return redirect()->route('erro')->withErrors([
            'error' => 'Erro ao processar o pagamento. Tente novamente mais tarde.',
        ]);
    }
}