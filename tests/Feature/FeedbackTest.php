<?php

namespace Tests\Feature;
use App\Http\Controllers\Controller;
use App\Modules\Feedback\Entity\Feedback;
use Tests\TestCase;
use App\Modules\Admin\Entity\Admin;
use App\Modules\User\Entity\User;


class FeedbackTest extends TestCase
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
    public function create_feedback()
    {
        $this->actingAs($this->user)
            ->postJson(route('api.feedback.store'), [
                'name' => 'Lorem',
            ])
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseHas('feedback', [
            'name' => 'Lorem',
        ]);
    }

    /** @test */
    public function update_feedback()
    {
        $feedback = Feedback::factory()->create();

        $this->actingAs($this->user)
            ->putJson(route('api.feedback.update', $feedback->id), [
                'name' => 'Updated feedback',
            ])
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseHas('feedback', [
            'id' => $feedback->id,
            'name' => 'Updated feedback',
        ]);
    }

    /** @test */
    public function show_feedback()
    {
        $feedback = Feedback::factory()->create();

        $this->actingAs($this->user)
            ->getJson(route('api.feedback.show', $feedback->id))
            ->assertSuccessful()
            ->assertJson([
                'data' => [
                    'name' => $feedback->name,
                ],
            ]);
    }

    /** @test */
    public function list_feedback()
    {
        $feedback = Feedback::factory()->count(2)->create()->map(function ($feedback) {
            return $feedback->only(['id', 'name']);
        });

        $this->actingAs($this->user)
            ->getJson(route('api.feedback.index'))
            ->assertSuccessful()
            ->assertJson([
                'data' => $feedback->toArray(),
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
    public function delete_feedback()
    {
        $feedback = Feedback::factory()->create([
            'name' => 'Feedback for delete',
        ]);

        $this->actingAs($this->user)
            ->deleteJson(route('api.feedback.update', $feedback->id))
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseMissing('feedback', [
            'id' => $feedback->id,
            'name' => 'Feedback for delete',
        ]);
    }
}
