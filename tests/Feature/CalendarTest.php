<?php

namespace Tests\Feature;
use App\Http\Controllers\Controller;
use App\Modules\Calendar\Entity\Calendar;
use Tests\TestCase;
use App\Modules\Admin\Entity\Admin;
use App\Modules\User\Entity\User;


class CalendarTest extends TestCase
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
            ->postJson(route('api.calendars.store'), [
                'name' => 'Lorem',
            ])
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseHas('calendars', [
            'name' => 'Lorem',
        ]);
    }

    /** @test */
    public function update_calendar()
    {
        $calendar = Calendar::factory()->create();

        $this->actingAs($this->user)
            ->putJson(route('api.calendars.update', $calendar->id), [
                'name' => 'Updated calendar',
            ])
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseHas('calendars', [
            'id' => $calendar->id,
            'name' => 'Updated calendar',
        ]);
    }

    /** @test */
    public function show_calendar()
    {
        $calendar = Calendar::factory()->create();

        $this->actingAs($this->user)
            ->getJson(route('api.calendars.show', $calendar->id))
            ->assertSuccessful()
            ->assertJson([
                'data' => [
                    'name' => $calendar->name,
                ],
            ]);
    }

    /** @test */
    public function list_calendar()
    {
        $calendars = Calendar::factory()->count(2)->create()->map(function ($calendar) {
            return $calendar->only(['id', 'name']);
        });

        $this->actingAs($this->user)
            ->getJson(route('api.calendars.index'))
            ->assertSuccessful()
            ->assertJson([
                'data' => $calendars->toArray(),
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
        $calendar = Calendar::factory()->create([
            'name' => 'Calendar for delete',
        ]);

        $this->actingAs($this->user)
            ->deleteJson(route('api.calendars.update', $calendar->id))
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseMissing('calendars', [
            'id' => $calendar->id,
            'name' => 'Calendar for delete',
        ]);
    }
}
