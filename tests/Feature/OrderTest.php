<?php

namespace Tests\Feature;
use App\Http\Controllers\Controller;
use App\Modules\Order\Entity\Order;
use Tests\TestCase;
use App\Modules\Admin\Entity\Admin;
use App\Modules\User\Entity\User;


class OrderTest extends TestCase
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
            ->postJson(route('api.orders.store'), [
                'name' => 'Lorem',
            ])
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseHas('orders', [
            'name' => 'Lorem',
        ]);
    }

    /** @test */
    public function update_order()
    {
        $order = Order::factory()->create();

        $this->actingAs($this->user)
            ->putJson(route('api.orders.update', $order->id), [
                'name' => 'Updated order',
            ])
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'name' => 'Updated order',
        ]);
    }

    /** @test */
    public function show_order()
    {
        $order = Order::factory()->create();

        $this->actingAs($this->user)
            ->getJson(route('api.orders.show', $order->id))
            ->assertSuccessful()
            ->assertJson([
                'data' => [
                    'name' => $order->name,
                ],
            ]);
    }

    /** @test */
    public function list_order()
    {
        $orders = Order::factory()->count(2)->create()->map(function ($order) {
            return $order->only(['id', 'name']);
        });

        $this->actingAs($this->user)
            ->getJson(route('api.orders.index'))
            ->assertSuccessful()
            ->assertJson([
                'data' => $orders->toArray(),
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
        $order = Order::factory()->create([
            'name' => 'Order for delete',
        ]);

        $this->actingAs($this->user)
            ->deleteJson(route('api.orders.update', $order->id))
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseMissing('orders', [
            'id' => $order->id,
            'name' => 'Order for delete',
        ]);
    }
}
