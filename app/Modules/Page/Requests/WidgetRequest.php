<?php

namespace App\Modules\Page\Requests;

use App\Modules\Page\Entity\Widget;
use Illuminate\Foundation\Http\FormRequest;

class WidgetRequest extends FormRequest
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
            Widget::COLUMN_NAME => 'required|string',
        ];
    }
}
