<?php

namespace App\Modules\Order\Requests;

use App\Modules\Order\Entity\OrderPayment;
use Illuminate\Foundation\Http\FormRequest;

class OrderPaymentRequest extends FormRequest
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
            'amount' => ['required', 'numeric'],
            'method' => ['required', 'numeric'],
            'order_id' => ['required', 'numeric'],
        ];
    }
}
