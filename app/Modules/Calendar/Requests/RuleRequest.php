<?php

namespace App\Modules\Calendar\Requests;

use App\Modules\Calendar\Entity\Rule;
use Illuminate\Foundation\Http\FormRequest;

class RuleRequest extends FormRequest
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
            'regularity' => ['required', 'integer']
        ];
    }
}
