<?php

namespace Tests\Feature;
use App\Http\Controllers\Controller;
use App\Modules\Employee\Entity\Message;
use Tests\TestCase;
use App\Modules\Admin\Entity\Admin;
use App\Modules\User\Entity\User;


class MessageTest extends TestCase
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
            ->postJson(route('api.messages.store'), [
                'name' => 'Lorem',
            ])
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseHas('messages', [
            'name' => 'Lorem',
        ]);
    }

    /** @test */
    public function update_employee()
    {
        $message = Message::factory()->create();

        $this->actingAs($this->user)
            ->putJson(route('api.messages.update', $message->id), [
                'name' => 'Updated message',
            ])
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseHas('messages', [
            'id' => $message->id,
            'name' => 'Updated message',
        ]);
    }

    /** @test */
    public function show_employee()
    {
        $message = Message::factory()->create();

        $this->actingAs($this->user)
            ->getJson(route('api.messages.show', $message->id))
            ->assertSuccessful()
            ->assertJson([
                'data' => [
                    'name' => $message->name,
                ],
            ]);
    }

    /** @test */
    public function list_employee()
    {
        $messages = Message::factory()->count(2)->create()->map(function ($message) {
            return $message->only(['id', 'name']);
        });

        $this->actingAs($this->user)
            ->getJson(route('api.messages.index'))
            ->assertSuccessful()
            ->assertJson([
                'data' => $messages->toArray(),
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
        $message = Message::factory()->create([
            'name' => 'Message for delete',
        ]);

        $this->actingAs($this->user)
            ->deleteJson(route('api.messages.update', $message->id))
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseMissing('messages', [
            'id' => $message->id,
            'name' => 'Message for delete',
        ]);
    }
}
