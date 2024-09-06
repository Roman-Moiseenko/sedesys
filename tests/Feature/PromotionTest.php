<?php

namespace Tests\Feature;
use App\Http\Controllers\Controller;
use App\Modules\Discount\Entity\Promotion;
use Tests\TestCase;
use App\Modules\Admin\Entity\Admin;
use App\Modules\User\Entity\User;


class PromotionTest extends TestCase
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
    public function create_discount()
    {
        $this->actingAs($this->user)
            ->postJson(route('api.promotions.store'), [
                'name' => 'Lorem',
            ])
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseHas('promotions', [
            'name' => 'Lorem',
        ]);
    }

    /** @test */
    public function update_discount()
    {
        $promotion = Promotion::factory()->create();

        $this->actingAs($this->user)
            ->putJson(route('api.promotions.update', $promotion->id), [
                'name' => 'Updated promotion',
            ])
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseHas('promotions', [
            'id' => $promotion->id,
            'name' => 'Updated promotion',
        ]);
    }

    /** @test */
    public function show_discount()
    {
        $promotion = Promotion::factory()->create();

        $this->actingAs($this->user)
            ->getJson(route('api.promotions.show', $promotion->id))
            ->assertSuccessful()
            ->assertJson([
                'data' => [
                    'name' => $promotion->name,
                ],
            ]);
    }

    /** @test */
    public function list_discount()
    {
        $promotions = Promotion::factory()->count(2)->create()->map(function ($promotion) {
            return $promotion->only(['id', 'name']);
        });

        $this->actingAs($this->user)
            ->getJson(route('api.promotions.index'))
            ->assertSuccessful()
            ->assertJson([
                'data' => $promotions->toArray(),
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
    public function delete_discount()
    {
        $promotion = Promotion::factory()->create([
            'name' => 'Promotion for delete',
        ]);

        $this->actingAs($this->user)
            ->deleteJson(route('api.promotions.update', $promotion->id))
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseMissing('promotions', [
            'id' => $promotion->id,
            'name' => 'Promotion for delete',
        ]);
    }
}
