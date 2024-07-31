<?php

namespace Tests\Feature;
use App\Http\Controllers\Controller;
use App\Modules\Page\Entity\Contact;
use Tests\TestCase;
use App\Modules\Admin\Entity\Admin;
use App\Modules\User\Entity\User;


class ContactTest extends TestCase
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
            ->postJson(route('api.contacts.store'), [
                'name' => 'Lorem',
            ])
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseHas('contacts', [
            'name' => 'Lorem',
        ]);
    }

    /** @test */
    public function update_page()
    {
        $contact = Contact::factory()->create();

        $this->actingAs($this->user)
            ->putJson(route('api.contacts.update', $contact->id), [
                'name' => 'Updated contact',
            ])
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseHas('contacts', [
            'id' => $contact->id,
            'name' => 'Updated contact',
        ]);
    }

    /** @test */
    public function show_page()
    {
        $contact = Contact::factory()->create();

        $this->actingAs($this->user)
            ->getJson(route('api.contacts.show', $contact->id))
            ->assertSuccessful()
            ->assertJson([
                'data' => [
                    'name' => $contact->name,
                ],
            ]);
    }

    /** @test */
    public function list_page()
    {
        $contacts = Contact::factory()->count(2)->create()->map(function ($contact) {
            return $contact->only(['id', 'name']);
        });

        $this->actingAs($this->user)
            ->getJson(route('api.contacts.index'))
            ->assertSuccessful()
            ->assertJson([
                'data' => $contacts->toArray(),
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
        $contact = Contact::factory()->create([
            'name' => 'Contact for delete',
        ]);

        $this->actingAs($this->user)
            ->deleteJson(route('api.contacts.update', $contact->id))
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseMissing('contacts', [
            'id' => $contact->id,
            'name' => 'Contact for delete',
        ]);
    }
}
