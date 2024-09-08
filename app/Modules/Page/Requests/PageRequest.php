<?php

namespace App\Modules\Page\Requests;

use App\Modules\Page\Entity\Page;
use Illuminate\Foundation\Http\FormRequest;

class PageRequest extends FormRequest
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
            'displayed.name' => ['required', 'max:33'],
        ];
    }
}
