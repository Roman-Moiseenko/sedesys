<?php

namespace App\Modules\Service\Requests;

use App\Modules\Service\Entity\Service;
use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
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

            //'breadcrumb.photo_id' => ['required', 'integer'],
           // 'breadcrumb.caption' => ['required', 'string'],
        ];
    }
}
