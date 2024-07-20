<?php
declare(strict_types=1);

namespace App\Modules\Admin\Request;

use App\Modules\Admin\Entity\Admin;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StaffRequest extends FormRequest
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
        $rules = [
            'POST' => [
                'name' => ['required', 'max:20'],
                'phone' => ['required', 'min:10'],
                'password' => ['required', 'min:6'],
                'post' => ['required', 'min:3'],
                'role' => ['required', Rule::in([Admin::ROLE_CHIEF, Admin::ROLE_STAFF, Admin::ROLE_ADMIN])],
                'surname' => ['required', 'min:2'],
                'firstname' => ['required', 'min:2'],
            ],
            'PUT' => [
                'name' => ['required', 'max:20'],
                'phone' => ['required', 'min:10'],
                'post' => ['required', 'min:3'],
                'role' => ['required', Rule::in([Admin::ROLE_CHIEF, Admin::ROLE_STAFF, Admin::ROLE_ADMIN])],
                'surname' => ['required', 'min:2'],
                'firstname' => ['required', 'min:2'],
            ],
        ];

        return $rules[$this->method()];
    }
}
