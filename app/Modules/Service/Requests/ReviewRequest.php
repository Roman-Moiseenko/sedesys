<?php

namespace App\Modules\Service\Requests;

use App\Modules\Service\Entity\Review;
use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
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
            'external' => ['required', 'string'],
            'service_id' => ['required', 'integer'],
            'rating' => ['required', 'integer'],
            'text' => ['required', 'string'],
            'link_review' => ['required', 'string'],
            'user_name' => ['required', 'string'],
        ];
    }
}
