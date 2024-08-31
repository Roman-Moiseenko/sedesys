<?php

namespace Tests\Feature;
use App\Http\Controllers\Controller;
use App\Modules\Service\Entity\Review;
use Tests\TestCase;
use App\Modules\Admin\Entity\Admin;
use App\Modules\User\Entity\User;


class ReviewTest extends TestCase
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
            ->postJson(route('api.reviews.store'), [
                'name' => 'Lorem',
            ])
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseHas('reviews', [
            'name' => 'Lorem',
        ]);
    }

    /** @test */
    public function update_service()
    {
        $review = Review::factory()->create();

        $this->actingAs($this->user)
            ->putJson(route('api.reviews.update', $review->id), [
                'name' => 'Updated review',
            ])
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseHas('reviews', [
            'id' => $review->id,
            'name' => 'Updated review',
        ]);
    }

    /** @test */
    public function show_service()
    {
        $review = Review::factory()->create();

        $this->actingAs($this->user)
            ->getJson(route('api.reviews.show', $review->id))
            ->assertSuccessful()
            ->assertJson([
                'data' => [
                    'name' => $review->name,
                ],
            ]);
    }

    /** @test */
    public function list_service()
    {
        $reviews = Review::factory()->count(2)->create()->map(function ($review) {
            return $review->only(['id', 'name']);
        });

        $this->actingAs($this->user)
            ->getJson(route('api.reviews.index'))
            ->assertSuccessful()
            ->assertJson([
                'data' => $reviews->toArray(),
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
        $review = Review::factory()->create([
            'name' => 'Review for delete',
        ]);

        $this->actingAs($this->user)
            ->deleteJson(route('api.reviews.update', $review->id))
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseMissing('reviews', [
            'id' => $review->id,
            'name' => 'Review for delete',
        ]);
    }
}
