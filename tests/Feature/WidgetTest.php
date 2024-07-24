<?php

namespace Tests\Feature;
use App\Http\Controllers\Controller;
use App\Modules\Page\Entity\Widget;
use Tests\TestCase;
use App\Modules\Admin\Entity\Admin;
use App\Modules\User\Entity\User;


class WidgetTest extends TestCase
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
    public function create_page()
    {
        $this->actingAs($this->user)
            ->postJson(route('api.widgets.store'), [
                'name' => 'Lorem',
            ])
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseHas('widgets', [
            'name' => 'Lorem',
        ]);
    }

    /** @test */
    public function update_page()
    {
        $widget = Widget::factory()->create();

        $this->actingAs($this->user)
            ->putJson(route('api.widgets.update', $widget->id), [
                'name' => 'Updated widget',
            ])
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseHas('widgets', [
            'id' => $widget->id,
            'name' => 'Updated widget',
        ]);
    }

    /** @test */
    public function show_page()
    {
        $widget = Widget::factory()->create();

        $this->actingAs($this->user)
            ->getJson(route('api.widgets.show', $widget->id))
            ->assertSuccessful()
            ->assertJson([
                'data' => [
                    'name' => $widget->name,
                ],
            ]);
    }

    /** @test */
    public function list_page()
    {
        $widgets = Widget::factory()->count(2)->create()->map(function ($widget) {
            return $widget->only(['id', 'name']);
        });

        $this->actingAs($this->user)
            ->getJson(route('api.widgets.index'))
            ->assertSuccessful()
            ->assertJson([
                'data' => $widgets->toArray(),
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
    public function delete_page()
    {
        $widget = Widget::factory()->create([
            'name' => 'Widget for delete',
        ]);

        $this->actingAs($this->user)
            ->deleteJson(route('api.widgets.update', $widget->id))
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseMissing('widgets', [
            'id' => $widget->id,
            'name' => 'Widget for delete',
        ]);
    }
}
