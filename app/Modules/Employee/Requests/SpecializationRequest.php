<?php

namespace App\Modules\Employee\Requests;

use App\Modules\Employee\Entity\Specialization;
use Illuminate\Foundation\Http\FormRequest;

class SpecializationRequest extends FormRequest
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
            'displayed.name' => ['required', 'string'],
        ];
    }
}
