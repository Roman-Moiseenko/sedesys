<?php

namespace Tests\Feature;
use App\Http\Controllers\Controller;
use App\Modules\Mail\Entity\Outbox;
use Tests\TestCase;
use App\Modules\Admin\Entity\Admin;
use App\Modules\User\Entity\User;


class OutboxTest extends TestCase
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
    public function create_mail()
    {
        $this->actingAs($this->user)
            ->postJson(route('api.outboxes.store'), [
                'name' => 'Lorem',
            ])
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseHas('outboxes', [
            'name' => 'Lorem',
        ]);
    }

    /** @test */
    public function update_mail()
    {
        $outbox = Outbox::factory()->create();

        $this->actingAs($this->user)
            ->putJson(route('api.outboxes.update', $outbox->id), [
                'name' => 'Updated outbox',
            ])
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseHas('outboxes', [
            'id' => $outbox->id,
            'name' => 'Updated outbox',
        ]);
    }

    /** @test */
    public function show_mail()
    {
        $outbox = Outbox::factory()->create();

        $this->actingAs($this->user)
            ->getJson(route('api.outboxes.show', $outbox->id))
            ->assertSuccessful()
            ->assertJson([
                'data' => [
                    'name' => $outbox->name,
                ],
            ]);
    }

    /** @test */
    public function list_mail()
    {
        $outboxes = Outbox::factory()->count(2)->create()->map(function ($outbox) {
            return $outbox->only(['id', 'name']);
        });

        $this->actingAs($this->user)
            ->getJson(route('api.outboxes.index'))
            ->assertSuccessful()
            ->assertJson([
                'data' => $outboxes->toArray(),
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
    public function delete_mail()
    {
        $outbox = Outbox::factory()->create([
            'name' => 'Outbox for delete',
        ]);

        $this->actingAs($this->user)
            ->deleteJson(route('api.outboxes.update', $outbox->id))
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseMissing('outboxes', [
            'id' => $outbox->id,
            'name' => 'Outbox for delete',
        ]);
    }
}
