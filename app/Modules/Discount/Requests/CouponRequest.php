<?php

namespace App\Modules\Discount\Requests;

use App\Modules\Discount\Entity\Coupon;
use Illuminate\Foundation\Http\FormRequest;

class CouponRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'bonus' => ['required', 'numeric'],
        ];
    }
}
