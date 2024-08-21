<?php

namespace Tests\Feature;
use App\Http\Controllers\Controller;
use App\Modules\Employee\Entity\Specialization;
use Tests\TestCase;
use App\Modules\Admin\Entity\Admin;
use App\Modules\User\Entity\User;


class SpecializationTest extends TestCase
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
            ->postJson(route('api.specializations.store'), [
                'name' => 'Lorem',
            ])
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseHas('specializations', [
            'name' => 'Lorem',
        ]);
    }

    /** @test */
    public function update_employee()
    {
        $specialization = Specialization::factory()->create();

        $this->actingAs($this->user)
            ->putJson(route('api.specializations.update', $specialization->id), [
                'name' => 'Updated specialization',
            ])
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseHas('specializations', [
            'id' => $specialization->id,
            'name' => 'Updated specialization',
        ]);
    }

    /** @test */
    public function show_employee()
    {
        $specialization = Specialization::factory()->create();

        $this->actingAs($this->user)
            ->getJson(route('api.specializations.show', $specialization->id))
            ->assertSuccessful()
            ->assertJson([
                'data' => [
                    'name' => $specialization->name,
                ],
            ]);
    }

    /** @test */
    public function list_employee()
    {
        $specializations = Specialization::factory()->count(2)->create()->map(function ($specialization) {
            return $specialization->only(['id', 'name']);
        });

        $this->actingAs($this->user)
            ->getJson(route('api.specializations.index'))
            ->assertSuccessful()
            ->assertJson([
                'data' => $specializations->toArray(),
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
        $specialization = Specialization::factory()->create([
            'name' => 'Specialization for delete',
        ]);

        $this->actingAs($this->user)
            ->deleteJson(route('api.specializations.update', $specialization->id))
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseMissing('specializations', [
            'id' => $specialization->id,
            'name' => 'Specialization for delete',
        ]);
    }
}
