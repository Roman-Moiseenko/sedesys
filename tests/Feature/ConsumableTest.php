<?php

namespace Tests\Feature;
use App\Http\Controllers\Controller;
use App\Modules\Service\Entity\Consumable;
use Tests\TestCase;
use App\Modules\Admin\Entity\Admin;
use App\Modules\User\Entity\User;


class ConsumableTest extends TestCase
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
    public function create_service()
    {
        $this->actingAs($this->user)
            ->postJson(route('api.consumables.store'), [
                'name' => 'Lorem',
            ])
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseHas('consumables', [
            'name' => 'Lorem',
        ]);
    }

    /** @test */
    public function update_service()
    {
        $consumable = Consumable::factory()->create();

        $this->actingAs($this->user)
            ->putJson(route('api.consumables.update', $consumable->id), [
                'name' => 'Updated consumable',
            ])
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseHas('consumables', [
            'id' => $consumable->id,
            'name' => 'Updated consumable',
        ]);
    }

    /** @test */
    public function show_service()
    {
        $consumable = Consumable::factory()->create();

        $this->actingAs($this->user)
            ->getJson(route('api.consumables.show', $consumable->id))
            ->assertSuccessful()
            ->assertJson([
                'data' => [
                    'name' => $consumable->name,
                ],
            ]);
    }

    /** @test */
    public function list_service()
    {
        $consumables = Consumable::factory()->count(2)->create()->map(function ($consumable) {
            return $consumable->only(['id', 'name']);
        });

        $this->actingAs($this->user)
            ->getJson(route('api.consumables.index'))
            ->assertSuccessful()
            ->assertJson([
                'data' => $consumables->toArray(),
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
    public function delete_service()
    {
        $consumable = Consumable::factory()->create([
            'name' => 'Consumable for delete',
        ]);

        $this->actingAs($this->user)
            ->deleteJson(route('api.consumables.update', $consumable->id))
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseMissing('consumables', [
            'id' => $consumable->id,
            'name' => 'Consumable for delete',
        ]);
    }
}
