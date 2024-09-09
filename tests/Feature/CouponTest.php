<?php

namespace Tests\Feature;
use App\Http\Controllers\Controller;
use App\Modules\Discount\Entity\Coupon;
use Tests\TestCase;
use App\Modules\Admin\Entity\Admin;
use App\Modules\User\Entity\User;


class CouponTest extends TestCase
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
    public function create_discount()
    {
        $this->actingAs($this->user)
            ->postJson(route('api.coupons.store'), [
                'name' => 'Lorem',
            ])
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseHas('coupons', [
            'name' => 'Lorem',
        ]);
    }

    /** @test */
    public function update_discount()
    {
        $coupon = Coupon::factory()->create();

        $this->actingAs($this->user)
            ->putJson(route('api.coupons.update', $coupon->id), [
                'name' => 'Updated coupon',
            ])
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseHas('coupons', [
            'id' => $coupon->id,
            'name' => 'Updated coupon',
        ]);
    }

    /** @test */
    public function show_discount()
    {
        $coupon = Coupon::factory()->create();

        $this->actingAs($this->user)
            ->getJson(route('api.coupons.show', $coupon->id))
            ->assertSuccessful()
            ->assertJson([
                'data' => [
                    'name' => $coupon->name,
                ],
            ]);
    }

    /** @test */
    public function list_discount()
    {
        $coupons = Coupon::factory()->count(2)->create()->map(function ($coupon) {
            return $coupon->only(['id', 'name']);
        });

        $this->actingAs($this->user)
            ->getJson(route('api.coupons.index'))
            ->assertSuccessful()
            ->assertJson([
                'data' => $coupons->toArray(),
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
    public function delete_discount()
    {
        $coupon = Coupon::factory()->create([
            'name' => 'Coupon for delete',
        ]);

        $this->actingAs($this->user)
            ->deleteJson(route('api.coupons.update', $coupon->id))
            ->assertSuccessful()
            ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

        $this->assertDatabaseMissing('coupons', [
            'id' => $coupon->id,
            'name' => 'Coupon for delete',
        ]);
    }
}
