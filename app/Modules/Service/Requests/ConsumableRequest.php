<?php

namespace App\Modules\Service\Requests;

use App\Modules\Service\Entity\Consumable;
use Illuminate\Foundation\Http\FormRequest;

class ConsumableRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'price' => ['required', 'numeric'],
        ];
    }
}
