<?php

namespace Tests\Feature;
use App\Http\Controllers\Controller;
use App\Modules\Page\Entity\Page;
use Tests\TestCase;
use App\Modules\Admin\Entity\Admin;
use App\Modules\User\Entity\User;


class PageTest extends TestCase
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
            ->postJson(route('api.pages.store'), [
                'name' => 'Lorem',
            ])
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseHas('pages', [
            'name' => 'Lorem',
        ]);
    }

    /** @test */
    public function update_page()
    {
        $page = Page::factory()->create();

        $this->actingAs($this->user)
            ->putJson(route('api.pages.update', $page->id), [
                'name' => 'Updated page',
            ])
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseHas('pages', [
            'id' => $page->id,
            'name' => 'Updated page',
        ]);
    }

    /** @test */
    public function show_page()
    {
        $page = Page::factory()->create();

        $this->actingAs($this->user)
            ->getJson(route('api.pages.show', $page->id))
            ->assertSuccessful()
            ->assertJson([
                'data' => [
                    'name' => $page->name,
                ],
            ]);
    }

    /** @test */
    public function list_page()
    {
        $pages = Page::factory()->count(2)->create()->map(function ($page) {
            return $page->only(['id', 'name']);
        });

        $this->actingAs($this->user)
            ->getJson(route('api.pages.index'))
            ->assertSuccessful()
            ->assertJson([
                'data' => $pages->toArray(),
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
        $page = Page::factory()->create([
            'name' => 'Page for delete',
        ]);

        $this->actingAs($this->user)
            ->deleteJson(route('api.pages.update', $page->id))
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseMissing('pages', [
            'id' => $page->id,
            'name' => 'Page for delete',
        ]);
    }
}
