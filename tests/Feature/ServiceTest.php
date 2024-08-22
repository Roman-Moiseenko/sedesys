<?php

namespace Tests\Feature;
use App\Http\Controllers\Controller;
use App\Modules\Service\Entity\Service;
use Tests\TestCase;
use App\Modules\Admin\Entity\Admin;
use App\Modules\User\Entity\User;


class ServiceTest extends TestCase
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
            ->postJson(route('api.services.store'), [
                'name' => 'Lorem',
            ])
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseHas('services', [
            'name' => 'Lorem',
        ]);
    }

    /** @test */
    public function update_service()
    {
        $service = Service::factory()->create();

        $this->actingAs($this->user)
            ->putJson(route('api.services.update', $service->id), [
                'name' => 'Updated service',
            ])
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseHas('services', [
            'id' => $service->id,
            'name' => 'Updated service',
        ]);
    }

    /** @test */
    public function show_service()
    {
        $service = Service::factory()->create();

        $this->actingAs($this->user)
            ->getJson(route('api.services.show', $service->id))
            ->assertSuccessful()
            ->assertJson([
                'data' => [
                    'name' => $service->name,
                ],
            ]);
    }

    /** @test */
    public function list_service()
    {
        $services = Service::factory()->count(2)->create()->map(function ($service) {
            return $service->only(['id', 'name']);
        });

        $this->actingAs($this->user)
            ->getJson(route('api.services.index'))
            ->assertSuccessful()
            ->assertJson([
                'data' => $services->toArray(),
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
        $service = Service::factory()->create([
            'name' => 'Service for delete',
        ]);

        $this->actingAs($this->user)
            ->deleteJson(route('api.services.update', $service->id))
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseMissing('services', [
            'id' => $service->id,
            'name' => 'Service for delete',
        ]);
    }
}
