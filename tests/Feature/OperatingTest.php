<?php

namespace Tests\Feature;
use App\Http\Controllers\Controller;
use App\Modules\Employee\Entity\Operating;
use Tests\TestCase;
use App\Modules\Admin\Entity\Admin;
use App\Modules\User\Entity\User;


class OperatingTest extends TestCase
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
    public function create_employee()
    {
        $this->actingAs($this->user)
            ->postJson(route('api.operatings.store'), [
                'name' => 'Lorem',
            ])
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseHas('operatings', [
            'name' => 'Lorem',
        ]);
    }

    /** @test */
    public function update_employee()
    {
        $operating = Operating::factory()->create();

        $this->actingAs($this->user)
            ->putJson(route('api.operatings.update', $operating->id), [
                'name' => 'Updated operating',
            ])
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseHas('operatings', [
            'id' => $operating->id,
            'name' => 'Updated operating',
        ]);
    }

    /** @test */
    public function show_employee()
    {
        $operating = Operating::factory()->create();

        $this->actingAs($this->user)
            ->getJson(route('api.operatings.show', $operating->id))
            ->assertSuccessful()
            ->assertJson([
                'data' => [
                    'name' => $operating->name,
                ],
            ]);
    }

    /** @test */
    public function list_employee()
    {
        $operatings = Operating::factory()->count(2)->create()->map(function ($operating) {
            return $operating->only(['id', 'name']);
        });

        $this->actingAs($this->user)
            ->getJson(route('api.operatings.index'))
            ->assertSuccessful()
            ->assertJson([
                'data' => $operatings->toArray(),
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
    public function delete_employee()
    {
        $operating = Operating::factory()->create([
            'name' => 'Operating for delete',
        ]);

        $this->actingAs($this->user)
            ->deleteJson(route('api.operatings.update', $operating->id))
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseMissing('operatings', [
            'id' => $operating->id,
            'name' => 'Operating for delete',
        ]);
    }
}
