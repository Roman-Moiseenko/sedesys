<?php

namespace Tests\Feature;
use App\Http\Controllers\Controller;
use App\Modules\Mail\Entity\Inbox;
use Tests\TestCase;
use App\Modules\Admin\Entity\Admin;
use App\Modules\User\Entity\User;


class InboxTest extends TestCase
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
            ->postJson(route('api.inboxes.store'), [
                'name' => 'Lorem',
            ])
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseHas('inboxes', [
            'name' => 'Lorem',
        ]);
    }

    /** @test */
    public function update_mail()
    {
        $inbox = Inbox::factory()->create();

        $this->actingAs($this->user)
            ->putJson(route('api.inboxes.update', $inbox->id), [
                'name' => 'Updated inbox',
            ])
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseHas('inboxes', [
            'id' => $inbox->id,
            'name' => 'Updated inbox',
        ]);
    }

    /** @test */
    public function show_mail()
    {
        $inbox = Inbox::factory()->create();

        $this->actingAs($this->user)
            ->getJson(route('api.inboxes.show', $inbox->id))
            ->assertSuccessful()
            ->assertJson([
                'data' => [
                    'name' => $inbox->name,
                ],
            ]);
    }

    /** @test */
    public function list_mail()
    {
        $inboxes = Inbox::factory()->count(2)->create()->map(function ($inbox) {
            return $inbox->only(['id', 'name']);
        });

        $this->actingAs($this->user)
            ->getJson(route('api.inboxes.index'))
            ->assertSuccessful()
            ->assertJson([
                'data' => $inboxes->toArray(),
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
        $inbox = Inbox::factory()->create([
            'name' => 'Inbox for delete',
        ]);

        $this->actingAs($this->user)
            ->deleteJson(route('api.inboxes.update', $inbox->id))
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseMissing('inboxes', [
            'id' => $inbox->id,
            'name' => 'Inbox for delete',
        ]);
    }
}
