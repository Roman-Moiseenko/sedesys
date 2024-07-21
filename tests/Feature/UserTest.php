<?php

namespace Tests\Feature;
use App\Http\Controllers\Controller;
use App\Modules\User\Entity\User;
use Tests\TestCase;
use App\Modules\Admin\Entity\Admin;
use App\Modules\User\Entity\User;


class UserTest extends TestCase
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
    public function create_user()
    {
        $this->actingAs($this->user)
            ->postJson(route('api.users.store'), [
                'name' => 'Lorem',
            ])
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseHas('users', [
            'name' => 'Lorem',
        ]);
    }

    /** @test */
    public function update_user()
    {
        $user = User::factory()->create();

        $this->actingAs($this->user)
            ->putJson(route('api.users.update', $user->id), [
                'name' => 'Updated user',
            ])
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated user',
        ]);
    }

    /** @test */
    public function show_user()
    {
        $user = User::factory()->create();

        $this->actingAs($this->user)
            ->getJson(route('api.users.show', $user->id))
            ->assertSuccessful()
            ->assertJson([
                'data' => [
                    'name' => $user->name,
                ],
            ]);
    }

    /** @test */
    public function list_user()
    {
        $users = User::factory()->count(2)->create()->map(function ($user) {
            return $user->only(['id', 'name']);
        });

        $this->actingAs($this->user)
            ->getJson(route('api.users.index'))
            ->assertSuccessful()
            ->assertJson([
                'data' => $users->toArray(),
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
    public function delete_user()
    {
        $user = User::factory()->create([
            'name' => 'User for delete',
        ]);

        $this->actingAs($this->user)
            ->deleteJson(route('api.users.update', $user->id))
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
            'name' => 'User for delete',
        ]);
    }
}
