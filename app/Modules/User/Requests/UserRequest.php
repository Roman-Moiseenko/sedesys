<?php

namespace App\Modules\User\Requests;

use App\Modules\User\Entity\User;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'phone' => ['required', 'integer', 'min:12'],
            'firstname' => ['required', 'string', 'min:2'],
        ];
    }
}
