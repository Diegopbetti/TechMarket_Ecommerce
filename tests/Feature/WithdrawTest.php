<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WithdrawTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_withdraw_valid_amount(): void
    {
        $user = User::factory()->create(['balance' => 500.00]);

        $response = $this->actingAs($user)->post(route('withdraw.process'), [
            'value' => 200.00,
        ]);

        $response->assertRedirect(route('withdraw'));
        $response->assertSessionHas('success', 'Saque realizado com sucesso!');
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'balance' => 300.00,
        ]);
    }

    public function test_user_can_withdraw_exact_total_balance_boundary(): void
    {
        $user = User::factory()->create(['balance' => 150.50]);

        $response = $this->actingAs($user)->post(route('withdraw.process'), [
            'value' => 150.50,
        ]);

        $response->assertRedirect(route('withdraw'));
        $this->assertEquals(0.00, $user->fresh()->balance);
    }

    public function test_user_cannot_withdraw_more_than_available_balance(): void
    {
        $user = User::factory()->create(['balance' => 100.00]);

        $response = $this->actingAs($user)->post(route('withdraw.process'), [
            'value' => 100.01,
        ]);

        $response->assertSessionHasErrors(['value' => 'Saldo insuficiente.']);
        $this->assertEquals(100.00, $user->fresh()->balance);
    }

    public function test_user_cannot_withdraw_zero_or_negative_values(): void
    {
        $user = User::factory()->create(['balance' => 100.00]);

        $response = $this->actingAs($user)->post(route('withdraw.process'), [
            'value' => 0,
        ]);

        $response->assertSessionHasErrors(['value']);
        $this->assertEquals(100.00, $user->fresh()->balance);
    }
}