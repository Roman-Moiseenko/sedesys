<?php

namespace Tests\Feature;
use App\Http\Controllers\Controller;
use App\Modules\Employee\Entity\Employee;
use Tests\TestCase;
use App\Modules\Admin\Entity\Admin;
use App\Modules\User\Entity\User;


class EmployeeTest extends TestCase
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
    public function create_employee()
    {
        $this->actingAs($this->user)
            ->postJson(route('api.employees.store'), [
                'name' => 'Lorem',
            ])
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseHas('employees', [
            'name' => 'Lorem',
        ]);
    }

    /** @test */
    public function update_employee()
    {
        $employee = Employee::factory()->create();

        $this->actingAs($this->user)
            ->putJson(route('api.employees.update', $employee->id), [
                'name' => 'Updated employee',
            ])
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseHas('employees', [
            'id' => $employee->id,
            'name' => 'Updated employee',
        ]);
    }

    /** @test */
    public function show_employee()
    {
        $employee = Employee::factory()->create();

        $this->actingAs($this->user)
            ->getJson(route('api.employees.show', $employee->id))
            ->assertSuccessful()
            ->assertJson([
                'data' => [
                    'name' => $employee->name,
                ],
            ]);
    }

    /** @test */
    public function list_employee()
    {
        $employees = Employee::factory()->count(2)->create()->map(function ($employee) {
            return $employee->only(['id', 'name']);
        });

        $this->actingAs($this->user)
            ->getJson(route('api.employees.index'))
            ->assertSuccessful()
            ->assertJson([
                'data' => $employees->toArray(),
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
    public function delete_employee()
    {
        $employee = Employee::factory()->create([
            'name' => 'Employee for delete',
        ]);

        $this->actingAs($this->user)
            ->deleteJson(route('api.employees.update', $employee->id))
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseMissing('employees', [
            'id' => $employee->id,
            'name' => 'Employee for delete',
        ]);
    }
}
