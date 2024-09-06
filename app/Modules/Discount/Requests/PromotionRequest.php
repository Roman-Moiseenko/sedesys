<?php

namespace App\Modules\Discount\Requests;

use App\Modules\Discount\Entity\Promotion;
use Illuminate\Foundation\Http\FormRequest;

class PromotionRequest extends FormRequest
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
            'start_at' => ['required_with:finish_at',],
            'finish_at' => ['required_with:start_at',],
            'discount' => ['required', 'numeric', 'min:1'],
            'condition_url' => ['required', 'string'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Не указали название акции',
            'condition_url.required' => 'Нет ссылки на условия',
            'discount.required' => 'Укажите процент скидки'
        ];
    }
}
