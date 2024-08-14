<?php

namespace Tests\Feature;
use App\Http\Controllers\Controller;
use App\Modules\Mail\Entity\SystemMail;
use Tests\TestCase;
use App\Modules\Admin\Entity\Admin;
use App\Modules\User\Entity\User;


class SystemMailTest extends TestCase
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
    public function create_mail()
    {
        $this->actingAs($this->user)
            ->postJson(route('api.systemMails.store'), [
                'name' => 'Lorem',
            ])
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseHas('systemMails', [
            'name' => 'Lorem',
        ]);
    }

    /** @test */
    public function update_mail()
    {
        $systemMail = SystemMail::factory()->create();

        $this->actingAs($this->user)
            ->putJson(route('api.systemMails.update', $systemMail->id), [
                'name' => 'Updated systemMail',
            ])
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseHas('systemMails', [
            'id' => $systemMail->id,
            'name' => 'Updated systemMail',
        ]);
    }

    /** @test */
    public function show_mail()
    {
        $systemMail = SystemMail::factory()->create();

        $this->actingAs($this->user)
            ->getJson(route('api.systemMails.show', $systemMail->id))
            ->assertSuccessful()
            ->assertJson([
                'data' => [
                    'name' => $systemMail->name,
                ],
            ]);
    }

    /** @test */
    public function list_mail()
    {
        $systemMails = SystemMail::factory()->count(2)->create()->map(function ($systemMail) {
            return $systemMail->only(['id', 'name']);
        });

        $this->actingAs($this->user)
            ->getJson(route('api.systemMails.index'))
            ->assertSuccessful()
            ->assertJson([
                'data' => $systemMails->toArray(),
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
    public function delete_mail()
    {
        $systemMail = SystemMail::factory()->create([
            'name' => 'SystemMail for delete',
        ]);

        $this->actingAs($this->user)
            ->deleteJson(route('api.systemMails.update', $systemMail->id))
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseMissing('systemMails', [
            'id' => $systemMail->id,
            'name' => 'SystemMail for delete',
        ]);
    }
}
