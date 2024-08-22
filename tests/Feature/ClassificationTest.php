<?php

namespace Tests\Feature;
use App\Http\Controllers\Controller;
use App\Modules\Service\Entity\Classification;
use Tests\TestCase;
use App\Modules\Admin\Entity\Admin;
use App\Modules\User\Entity\User;


class ClassificationTest extends TestCase
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
            ->postJson(route('api.classifications.store'), [
                'name' => 'Lorem',
            ])
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseHas('classifications', [
            'name' => 'Lorem',
        ]);
    }

    /** @test */
    public function update_service()
    {
        $classification = Classification::factory()->create();

        $this->actingAs($this->user)
            ->putJson(route('api.classifications.update', $classification->id), [
                'name' => 'Updated classification',
            ])
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseHas('classifications', [
            'id' => $classification->id,
            'name' => 'Updated classification',
        ]);
    }

    /** @test */
    public function show_service()
    {
        $classification = Classification::factory()->create();

        $this->actingAs($this->user)
            ->getJson(route('api.classifications.show', $classification->id))
            ->assertSuccessful()
            ->assertJson([
                'data' => [
                    'name' => $classification->name,
                ],
            ]);
    }

    /** @test */
    public function list_service()
    {
        $classifications = Classification::factory()->count(2)->create()->map(function ($classification) {
            return $classification->only(['id', 'name']);
        });

        $this->actingAs($this->user)
            ->getJson(route('api.classifications.index'))
            ->assertSuccessful()
            ->assertJson([
                'data' => $classifications->toArray(),
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
        $classification = Classification::factory()->create([
            'name' => 'Classification for delete',
        ]);

        $this->actingAs($this->user)
            ->deleteJson(route('api.classifications.update', $classification->id))
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseMissing('classifications', [
            'id' => $classification->id,
            'name' => 'Classification for delete',
        ]);
    }
}
