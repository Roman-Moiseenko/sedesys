<?php

namespace Tests\Feature;
use App\Http\Controllers\Controller;
use App\Modules\Feedback\Entity\Template;
use Tests\TestCase;
use App\Modules\Admin\Entity\Admin;
use App\Modules\User\Entity\User;


class TemplateTest extends TestCase
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
            ->postJson(route('api.templates.store'), [
                'name' => 'Lorem',
            ])
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseHas('templates', [
            'name' => 'Lorem',
        ]);
    }

    /** @test */
    public function update_feedback()
    {
        $template = Template::factory()->create();

        $this->actingAs($this->user)
            ->putJson(route('api.templates.update', $template->id), [
                'name' => 'Updated template',
            ])
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseHas('templates', [
            'id' => $template->id,
            'name' => 'Updated template',
        ]);
    }

    /** @test */
    public function show_feedback()
    {
        $template = Template::factory()->create();

        $this->actingAs($this->user)
            ->getJson(route('api.templates.show', $template->id))
            ->assertSuccessful()
            ->assertJson([
                'data' => [
                    'name' => $template->name,
                ],
            ]);
    }

    /** @test */
    public function list_feedback()
    {
        $templates = Template::factory()->count(2)->create()->map(function ($template) {
            return $template->only(['id', 'name']);
        });

        $this->actingAs($this->user)
            ->getJson(route('api.templates.index'))
            ->assertSuccessful()
            ->assertJson([
                'data' => $templates->toArray(),
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
        $template = Template::factory()->create([
            'name' => 'Template for delete',
        ]);

        $this->actingAs($this->user)
            ->deleteJson(route('api.templates.update', $template->id))
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseMissing('templates', [
            'id' => $template->id,
            'name' => 'Template for delete',
        ]);
    }
}
