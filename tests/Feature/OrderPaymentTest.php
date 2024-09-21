<?php

namespace Tests\Feature;
use App\Http\Controllers\Controller;
use App\Modules\Order\Entity\OrderPayment;
use Tests\TestCase;
use App\Modules\Admin\Entity\Admin;
use App\Modules\User\Entity\User;


class OrderPaymentTest extends TestCase
{

    protected User $user;
    protected Admin $admin;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->admin = Admin::factory()->create();
    }

    /** @test */
    public function create_order()
    {
        $this->actingAs($this->user)
            ->postJson(route('api.orderPayments.store'), [
                'name' => 'Lorem',
            ])
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseHas('orderPayments', [
            'name' => 'Lorem',
        ]);
    }

    /** @test */
    public function update_order()
    {
        $orderPayment = OrderPayment::factory()->create();

        $this->actingAs($this->user)
            ->putJson(route('api.orderPayments.update', $orderPayment->id), [
                'name' => 'Updated orderPayment',
            ])
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseHas('orderPayments', [
            'id' => $orderPayment->id,
            'name' => 'Updated orderPayment',
        ]);
    }

    /** @test */
    public function show_order()
    {
        $orderPayment = OrderPayment::factory()->create();

        $this->actingAs($this->user)
            ->getJson(route('api.orderPayments.show', $orderPayment->id))
            ->assertSuccessful()
            ->assertJson([
                'data' => [
                    'name' => $orderPayment->name,
                ],
            ]);
    }

    /** @test */
    public function list_order()
    {
        $orderPayments = OrderPayment::factory()->count(2)->create()->map(function ($orderPayment) {
            return $orderPayment->only(['id', 'name']);
        });

        $this->actingAs($this->user)
            ->getJson(route('api.orderPayments.index'))
            ->assertSuccessful()
            ->assertJson([
                'data' => $orderPayments->toArray(),
            ])
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'name'],
                ],
                'links',
                'meta',
            ]);
    }

    /** @test */
    public function delete_order()
    {
        $orderPayment = OrderPayment::factory()->create([
            'name' => 'OrderPayment for delete',
        ]);

        $this->actingAs($this->user)
            ->deleteJson(route('api.orderPayments.update', $orderPayment->id))
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseMissing('orderPayments', [
            'id' => $orderPayment->id,
            'name' => 'OrderPayment for delete',
        ]);
    }
}
