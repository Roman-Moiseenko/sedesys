<?php

namespace Tests\Feature;
use App\Http\Controllers\Controller;
use App\Modules\Calendar\Entity\Rule;
use Tests\TestCase;
use App\Modules\Admin\Entity\Admin;
use App\Modules\User\Entity\User;


class RuleTest extends TestCase
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
    public function create_calendar()
    {
        $this->actingAs($this->user)
            ->postJson(route('api.rules.store'), [
                'name' => 'Lorem',
            ])
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseHas('rules', [
            'name' => 'Lorem',
        ]);
    }

    /** @test */
    public function update_calendar()
    {
        $rule = Rule::factory()->create();

        $this->actingAs($this->user)
            ->putJson(route('api.rules.update', $rule->id), [
                'name' => 'Updated rule',
            ])
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseHas('rules', [
            'id' => $rule->id,
            'name' => 'Updated rule',
        ]);
    }

    /** @test */
    public function show_calendar()
    {
        $rule = Rule::factory()->create();

        $this->actingAs($this->user)
            ->getJson(route('api.rules.show', $rule->id))
            ->assertSuccessful()
            ->assertJson([
                'data' => [
                    'name' => $rule->name,
                ],
            ]);
    }

    /** @test */
    public function list_calendar()
    {
        $rules = Rule::factory()->count(2)->create()->map(function ($rule) {
            return $rule->only(['id', 'name']);
        });

        $this->actingAs($this->user)
            ->getJson(route('api.rules.index'))
            ->assertSuccessful()
            ->assertJson([
                'data' => $rules->toArray(),
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
    public function delete_calendar()
    {
        $rule = Rule::factory()->create([
            'name' => 'Rule for delete',
        ]);

        $this->actingAs($this->user)
            ->deleteJson(route('api.rules.update', $rule->id))
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseMissing('rules', [
            'id' => $rule->id,
            'name' => 'Rule for delete',
        ]);
    }
}
