<?php

namespace App\Modules\Employee\Requests;

use App\Modules\Employee\Entity\Employee;
use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
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
            'phone' => ['required', 'min:10'],
            'password' => ['required', 'min:6'],
            'surname' => ['required', 'min:2'],
            'firstname' => ['required', 'min:2'],
        ];
    }
}
