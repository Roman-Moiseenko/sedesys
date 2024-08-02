<?php

namespace Tests\Feature;
use App\Http\Controllers\Controller;
use App\Modules\Page\Entity\Gallery;
use Tests\TestCase;
use App\Modules\Admin\Entity\Admin;
use App\Modules\User\Entity\User;


class GalleryTest extends TestCase
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
            ->postJson(route('api.galleries.store'), [
                'name' => 'Lorem',
            ])
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseHas('galleries', [
            'name' => 'Lorem',
        ]);
    }

    /** @test */
    public function update_page()
    {
        $gallery = Gallery::factory()->create();

        $this->actingAs($this->user)
            ->putJson(route('api.galleries.update', $gallery->id), [
                'name' => 'Updated gallery',
            ])
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseHas('galleries', [
            'id' => $gallery->id,
            'name' => 'Updated gallery',
        ]);
    }

    /** @test */
    public function show_page()
    {
        $gallery = Gallery::factory()->create();

        $this->actingAs($this->user)
            ->getJson(route('api.galleries.show', $gallery->id))
            ->assertSuccessful()
            ->assertJson([
                'data' => [
                    'name' => $gallery->name,
                ],
            ]);
    }

    /** @test */
    public function list_page()
    {
        $galleries = Gallery::factory()->count(2)->create()->map(function ($gallery) {
            return $gallery->only(['id', 'name']);
        });

        $this->actingAs($this->user)
            ->getJson(route('api.galleries.index'))
            ->assertSuccessful()
            ->assertJson([
                'data' => $galleries->toArray(),
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
        $gallery = Gallery::factory()->create([
            'name' => 'Gallery for delete',
        ]);

        $this->actingAs($this->user)
            ->deleteJson(route('api.galleries.update', $gallery->id))
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseMissing('galleries', [
            'id' => $gallery->id,
            'name' => 'Gallery for delete',
        ]);
    }
}
