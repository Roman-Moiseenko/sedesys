<?php

namespace Tests\Feature;
use App\Http\Controllers\Controller;
use App\Modules\Setting\Entity\Setting;
use Tests\TestCase;
use App\Modules\Admin\Entity\Admin;
use App\Modules\User\Entity\User;


class SettingTest extends TestCase
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
    public function create_setting()
    {
        $this->actingAs($this->user)
            ->postJson(route('api.settings.store'), [
                'name' => 'Lorem',
            ])
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseHas('settings', [
            'name' => 'Lorem',
        ]);
    }

    /** @test */
    public function update_setting()
    {
        $setting = Setting::factory()->create();

        $this->actingAs($this->user)
            ->putJson(route('api.settings.update', $setting->id), [
                'name' => 'Updated setting',
            ])
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseHas('settings', [
            'id' => $setting->id,
            'name' => 'Updated setting',
        ]);
    }

    /** @test */
    public function show_setting()
    {
        $setting = Setting::factory()->create();

        $this->actingAs($this->user)
            ->getJson(route('api.settings.show', $setting->id))
            ->assertSuccessful()
            ->assertJson([
                'data' => [
                    'name' => $setting->name,
                ],
            ]);
    }

    /** @test */
    public function list_setting()
    {
        $settings = Setting::factory()->count(2)->create()->map(function ($setting) {
            return $setting->only(['id', 'name']);
        });

        $this->actingAs($this->user)
            ->getJson(route('api.settings.index'))
            ->assertSuccessful()
            ->assertJson([
                'data' => $settings->toArray(),
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
    public function delete_setting()
    {
        $setting = Setting::factory()->create([
            'name' => 'Setting for delete',
        ]);

        $this->actingAs($this->user)
            ->deleteJson(route('api.settings.update', $setting->id))
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseMissing('settings', [
            'id' => $setting->id,
            'name' => 'Setting for delete',
        ]);
    }
}
